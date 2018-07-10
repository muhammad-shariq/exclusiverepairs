<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geo_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
		$this->tbl_countries = "countries";
		$this->tbl_states = "states";
        $this->tbl_offices = "offices";
	}
	
    public function get_all_countries() 
    {
		$this->db->order_by('title', 'ASC');
        $query = $this->db->get($this->tbl_countries);
        return $query->result_array();
    }
	
    public function get_all_states() 
    {
		$this->db->order_by('name', 'ASC');
        $query = $this->db->get($this->tbl_states);
        return $query->result_array();
    }	
    
    public function get_all_offices() 
    {
		$this->db->order_by('title', 'ASC');
        $query = $this->db->get($this->tbl_offices);
        return $query->result_array();
    }
    
    public function get_office_by_id($id) 
    {
        $this->db->select('title')->from($this->tbl_offices)->where('id', $id);
        return $this->db->get()->row()->title;
    }         
}