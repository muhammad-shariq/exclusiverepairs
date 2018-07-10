<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    var $table = 'customers';
    var $column = array('name', 'phone', 'email', 'updated_datetime', 'created_datetime'); //set column field database for order and search
    var $order = array('id' => 'desc'); // default order
 
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all() 
    {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get($this->table);        
        return $query->result_array();
    }      
    
    public function get_where($params) 
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get_where($this->table, $params);        
        return $query->result_array();
    } 

    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        if($this->session->office_id != 0)
            $this->db->where("office_id", $this->session->office_id);        
 
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
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
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
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->delete($this->table, array('id' => $id));
    }

}