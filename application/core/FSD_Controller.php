<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FSD_Controller extends CI_Controller
{		
	 public function __construct()
	 {
	 	parent::__construct();
	 	## Ajax funcations can be called by ajax request ##
	 	if (substr($this->router->method, 0, 4) == 'ajax' && !$this->input->is_ajax_request()) 
        {
            show_404();
        }
	 }
	 
	 public function authorization() 
	 {
	 	if( $this->session->userdata('is_logged_in') !==  TRUE )
	   	{
	 		redirect('login?return_url='.str_replace($this->config->item('url_suffix'), "", current_url()));	
	   	}
	 }
}