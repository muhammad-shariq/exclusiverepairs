<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_model extends CI_Model
{
    var $table = 'jobs';
    var $table_customer = 'customers';
    var $table_job_items = 'job_items';
    var $table_office = 'offices';
    var $table_brand = 'brands';
    var $table_model = 'brand_models';
    var $column = array(); //set column field database for order and search
    var $order = array(); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->column = array(
            "$this->table.id", 
            "$this->table.delivery_date", 
            "$this->table.receive_date", 
            "$this->table.status", 
            "$this->table_customer.updated_datetime",
            "$this->table_customer.name"
        ); //set column field database for order and search
        $this->order = array("$this->table.id" => 'desc');
    }

    public function get_where($params) 
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get_where($this->table, $params);        
        return $query->result_array();
    }      
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table_customer)
        ->join($this->table, "{$this->table}.customer_id = {$this->table_customer}.id", 'inner');
        if($this->session->office_id != 0)
            $this->db->where("$this->table.office_id", $this->session->office_id);
 
        $i = 0;
     
        foreach ($this->column as $item) // loop column
        {   
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        if($this->session->office_id != 0)
            $this->db->where("office_id", $this->session->office_id);          
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function save_items($data)
    {
        $this->db->insert_batch($this->table_job_items, $data);
    }
 
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->delete($this->table, array('id' => $id));
    }

    public function delete_items_by_id($id)
    {
        $this->db->delete($this->table_job_items, array('job_id' => $id));
    }

    public function get_sum($job_id) 
    {
        $query = $this->db->select_sum('amount')->from($this->table_job_items)->where('job_id', $job_id)->get();        
        $row = $query->row();
        return $row->amount;
    }  

    public function get_items($job_id) 
    {
        $query = $this->db->get_where($this->table_job_items, array('job_id' => $job_id));        
        return $query->result_array();
    }

    public function get_invoice($job_id)
    {
        $job = array();
        $query = $this->db->select("{$this->table}.id, {$this->table}.delivery_date, {$this->table}.receive_date, {$this->table}.technician" )
        ->select("{$this->table_office}.title AS office,{$this->table_customer}.name, {$this->table_customer}.phone, {$this->table_customer}.email" )
        ->from($this->table_customer)
        ->join($this->table, "{$this->table}.customer_id = {$this->table_customer}.id", 'inner')
        ->join($this->table_office, "{$this->table}.office_id = {$this->table_office}.id", 'inner')
        ->where("{$this->table}.id", $job_id)
        ->get();
        if($query->num_rows() > 0)
        {
            $job = (array) $query->row();
            $query = $this->db->select("{$this->table_brand}.title AS brand, {$this->table_model}.title AS model")
            ->select("{$this->table_job_items}.*")
            ->from($this->table_job_items)
            ->join($this->table_model, "{$this->table_job_items}.brand_model_id = {$this->table_model}.id", 'inner')
            ->join($this->table_brand, "{$this->table_model}.brand_id = {$this->table_brand}.id", 'inner')
            ->where("{$this->table_job_items}.job_id", $job_id)
            ->get();
            $job['items'] = $query->result_array();                
        }
        return $job;
    }

    public function count_by_status($status)
    {
        $this->db->from($this->table);
        $this->db->where("status", $status);
        if($this->session->office_id != 0)
            $this->db->where("office_id", $this->session->office_id);
        return $this->db->count_all_results();
    }

    public function email_data($job_id)
    {
        $this->db->select("{$this->table}.id, {$this->table}.receive_date, {$this->table}.delivery_date, {$this->table_customer}.name, {$this->table_customer}.email")
        ->from($this->table)
        ->join($this->table_customer, "{$this->table}.customer_id={$this->table_customer}.id", 'inner')
        ->where("{$this->table}.id", $job_id);
        $query = $this->db->get();
        return (array) $query->row();
    }

    public function get_weekly_profit()
    {
        $this->db->select("SUM( {$this->table_job_items}.amount ) AS income, SUM( {$this->table_job_items}.amount ) - SUM( {$this->table_job_items}.cost ) AS profit")
        ->from($this->table)
        ->join($this->table_job_items, "{$this->table_job_items}.job_id={$this->table}.id", 'inner')
        ->where("{$this->table}.receive_date BETWEEN CURDATE()-INTERVAL 1 WEEK AND CURDATE()");
        $query = $this->db->get();
        return $query->row();
    }

    public function get_item_count_where($params)
    {
        $this->db->select('id');
        $this->db->from($this->table_job_items);
        $this->db->where($params);
        return $this->db->count_all_results();
    }    
}