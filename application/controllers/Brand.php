<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends FSD_Controller
{
	var $before_filter = array('name' => 'authorization', 'except' => array('login', 'forgot_password'));
	var $offices = array();
    
	public function __construct()
	{
		parent::__construct();
        $this->load->model('job_model');
        $this->load->model('device_model_model');
		$this->load->model('device_brand_model');
        $this->load->model('geo_model');
        $this->offices = $this->geo_model->get_all_offices();

        ## Only Admin Allow funcations ##
        if (!$this->session->is_admin && $this->router->method == 'ajax_delete') 
        {
            show_error('You are not authorized to access this page.', 403);
        }
	}

	public function index()
	{
        $data['offices'] = $this->offices;
		$data['page_title'] = 'Brands';
		$data['template'] = "brand/listing";
		$this->load->view("master_template", $data);
	}
	
	public function ajax_list()
    {
        $list = $this->device_brand_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brand) {
            $no++;
            $row = array();
            $row[] = $brand->id;
            $row[] = $brand->title;
 
            //add html for action
            $buttons = '<button class="btn btn-xs btn-primary" onclick="edit('."'".$brand->id."'".')"><i class="fa fa-pencil"></i> Edit</button>';
            if($this->session->is_admin)
                $buttons .= '<button class="btn btn-xs btn-danger" onclick="del('."'".$brand->id."'".')"><i class="fa fa-trash"></i> Delete</button>';

            $row[] = $buttons;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->device_brand_model->count_all(),
                        "recordsFiltered" => $this->device_brand_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->device_brand_model->get_by_id($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = $this->input->post(NULL, TRUE);
        $insert = $this->device_brand_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = $this->input->post(NULL, TRUE);
        $this->device_brand_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $count = $this->job_model->get_item_count_where( array('brand_id' => $id) );
        if($count > 0)
        {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(array('status' => FALSE), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }      

        $count = $this->device_model_model->get_count_where( array('brand_id' => $id) );
        if($count > 0)
        {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(array('status' => FALSE), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }           
        $this->device_brand_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $post = $this->input->post(NULL, TRUE);
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($post['title'] == '')
        {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'Title is required';
            $data['status'] = FALSE;
        }
        elseif (strlen($post['title']) > 255) 
        {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'Title can not be grather then 255 characters.';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }       
}