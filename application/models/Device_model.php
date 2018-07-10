<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device_model extends CI_Model
{
    var $table_brands = 'brands';
    var $table_brand_models = 'brand_models';
 
    public function __construct()
    {
        parent::__construct();
    }

    public function get_brands() 
    {
        $this->db->order_by('title', 'asc');
        $query = $this->db->get($this->table_brands);        
        return $query->result_array();
    }

    public function get_model_by_brand($brand_id) 
    {
        $this->db->order_by('title', 'asc');
        $query = $this->db->get_where($this->table_brand_models, array('brand_id' => $brand_id));        
        return $query->result_array();
    }    
}