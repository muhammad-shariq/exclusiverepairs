<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends FSD_Controller
{
	var $before_filter = array('name' => 'authorization', 'except' => array());
	var $offices = array();
    var $status = array( 'Pending', 'Ready', 'Picked-up' );
    
	public function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
        $this->load->model('geo_model');
        $this->load->model('customer_model');
        $this->load->model('email_model');
        $this->load->model('device_model');
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
		$data['page_title'] = 'Bookings';
		$data['template'] = "job/listing";
		$this->load->view("master_template", $data);
	}
	
	public function ajax_list()
    {
        $list = $this->job_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $job) {
            $no++;
            $row = array();
            $row[] = $job->id;
            $row[] = $job->name;
            $row[] = $job->email;            
            $row[] = $job->delivery_date;
            $row[] = $job->receive_date;
            $row[] = $this->job_model->get_sum($job->id);
            $row[] = $this->status[$job->status];
            $row[] = $job->updated_datetime;
 
            //add html for action
            $buttons = '<button class="btn btn-xs btn-primary" onclick="window.location=\''.site_url('job/edit/'.$job->id).'\'" title="Edit"><i class="fa fa-pencil"></i> Edit</button>';
            if($this->session->is_admin)
                $buttons .= '<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>';
            
            $buttons = '<div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">                        
                        <li><a href="'.site_url('job/recept/'.$job->id).'" target="_blank"><i class="fa fa-print"></i> Print</a></li>
                        <li><a href="'.site_url('job/edit/'.$job->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
            
            if($job->status == 0)                        
                $buttons .= '<li><a href="javascript:status_change('.$job->id.', 1)"><i class="fa fa-thumbs-up"></i> Ready to pick</a></li>';
            elseif($job->status == 1)
                $buttons .= '<li><a href="javascript:status_change('.$job->id.', 2)"><i class="fa fa-thumbs-up"></i> Picked-up</a></li>';

            if($this->session->is_admin)
                $buttons .= '<li class="divider"></li>
                            <li><a href="javascript:del('.$job->id.')"><i class="fa fa-trash"></i> Delete</a></li>';
            $buttons .= '</ul>
                        </div>'; 
            $row[] = $buttons;
            $data[] = $row;
        }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->job_model->count_all(),
                    "recordsFiltered" => $this->job_model->count_filtered(),
                    "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function add()
    {
        if($this->input->method(TRUE) === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('customer_id', 'Customer', 'required|integer');
            $this->form_validation->set_rules('receive_date', 'Receive Date', 'trim|required');
            $this->form_validation->set_rules('delivery_date', 'Receive Date', 'trim|required');
            $this->form_validation->set_rules('technician', 'Technician', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('notes', 'Notes', 'trim');

            $this->form_validation->set_rules('brand_id[]', 'Device Brand', 'required|integer');
            $this->form_validation->set_rules('brand_model_id[]', 'Device Model', 'required|integer');
            $this->form_validation->set_rules('device_number[]', 'IMEI/ ESN/ SN', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('color[]', 'Device Color', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('provider[]', 'Provider Info', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('device_password[]', 'Device Password', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('fault_discription[]', 'Fault Discription', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('amount[]', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('cost[]', 'Cost', 'trim|required|numeric');

            $this->form_validation->set_rules('power_on[]', 'Power On Check', 'required|integer');
            $this->form_validation->set_rules('charging[]', 'Charging Check', 'required|integer');
            $this->form_validation->set_rules('network[]', 'Network Check', 'required|integer');
            $this->form_validation->set_rules('display[]', 'Display Check', 'required|integer');
            $this->form_validation->set_rules('camera[]', 'Camera Check', 'required|integer');
            $this->form_validation->set_rules('battery[]', 'Battery Check', 'required|integer');
            
    
            if ($this->form_validation->run() !== FALSE)
            {
                $post = $this->input->post(NULL, TRUE);
                $data = array();

                $data['customer_id'] = $post['customer_id'];
                $data['employee_id'] = $this->session->employee_id;
                $data['office_id'] = $this->session->office_id;
                $data['technician'] = $post['technician'];
                $data['receive_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $post['receive_date'])));
                $data['delivery_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $post['delivery_date'])));
                $data['notes'] = $post['notes'];
                $data['status'] = 0;
                $data['updated_datetime'] = date("Y-m-d H:i:s");
                $data['created_datetime'] = date("Y-m-d H:i:s");

                $job_id = $this->job_model->save($data);

                ## Save Device Information ##
                $data = array();
                foreach ($post['brand_id'] as $k => $v) 
                {
                    $data[] = array(
                        'job_id' => $job_id,
                        'brand_id' => $v,
                        'brand_model_id' => $post['brand_model_id'][$k],
                        'device_number' => $post['device_number'][$k],
                        'color' => $post['color'][$k],
                        'provider' => $post['provider'][$k],
                        'device_password' => $post['device_password'][$k],
                        'power_on' => $post['power_on'][$k],
                        'charging' => $post['charging'][$k],
                        'network' => $post['network'][$k],
                        'display' => $post['display'][$k],
                        'camera' => $post['camera'][$k],
                        'battery' => $post['battery'][$k],
                        'fault_discription' => $post['fault_discription'][$k],
                        'amount' => abs($post['amount'][$k]),
                        'cost' => abs($post['cost'][$k])
                    );                    
                }
                $this->job_model->save_items($data);
                ## Send email notification ##
                $email_template = $this->email_model->get_by_id(1); //Order received
                if(!empty($email_template))
                {
                    $from_email = $email_template->from_email;
                    $from_name = $email_template->from_name;
                    $to_email = $email_template->to_email;
                    $subject = $email_template->subject;
                    $message = $email_template->message;

                    $data = $this->job_model->email_data($job_id);

                    $this->fsd->email_template($data, $from_email, $from_name, $to_email, $subject, $message);
                    $this->fsd->sent_email($from_email, $from_name, $to_email, $subject, $message );
                }
                ## End sent email ##
                $this->session->set_flashdata('success', 'Record has been saved successfully.');
                redirect('job/edit/'.$job_id);
            }
        }
        $data = array();
        $data['brands'] = $this->device_model->get_brands();
        $data['customers'] = $this->customer_model->get_all();
        $data['offices'] = $this->offices;
        $data['page_title'] = 'Bookings';
        $data['template'] = "job/add_edit";
        $this->load->view("master_template", $data);
    }

    public function edit($id)
    {
        if($this->input->method(TRUE) === 'POST')
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('customer_id', 'Customer', 'required|integer');
            $this->form_validation->set_rules('receive_date', 'Receive Date', 'trim|required');
            $this->form_validation->set_rules('delivery_date', 'Receive Date', 'trim|required');
            $this->form_validation->set_rules('technician', 'Technician', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('notes', 'Notes', 'trim');

            $this->form_validation->set_rules('brand_id[]', 'Device Brand', 'required|integer');
            $this->form_validation->set_rules('brand_model_id[]', 'Device Model', 'required|integer');
            $this->form_validation->set_rules('device_number[]', 'IMEI/ ESN/ SN', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('color[]', 'Device Color', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('provider[]', 'Provider Info', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('device_password[]', 'Device Password', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('fault_discription[]', 'Fault Discription', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('amount[]', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('cost[]', 'Cost', 'trim|required|numeric');

            $this->form_validation->set_rules('power_on[]', 'Power On Check', 'required|integer');
            $this->form_validation->set_rules('charging[]', 'Charging Check', 'required|integer');
            $this->form_validation->set_rules('network[]', 'Network Check', 'required|integer');
            $this->form_validation->set_rules('display[]', 'Display Check', 'required|integer');
            $this->form_validation->set_rules('camera[]', 'Camera Check', 'required|integer');
            $this->form_validation->set_rules('battery[]', 'Battery Check', 'required|integer');
            
    
            if ($this->form_validation->run() !== FALSE)
            {
                $post = $this->input->post(NULL, TRUE);
                $data = array();

                $data['customer_id'] = $post['customer_id'];
                $data['technician'] = $post['technician'];
                $data['receive_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $post['receive_date'])));
                $data['delivery_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $post['delivery_date'])));
                $data['notes'] = $post['notes'];
                $data['updated_datetime'] = date("Y-m-d H:i:s");

                $this->job_model->update($id, $data);

                ## Save Device Information ##
                $data = array();
                foreach ($post['brand_id'] as $k => $v) 
                {
                    $data[] = array(
                        'job_id' => $id,
                        'brand_id' => $v,
                        'brand_model_id' => $post['brand_model_id'][$k],
                        'device_number' => $post['device_number'][$k],
                        'color' => $post['color'][$k],
                        'provider' => $post['provider'][$k],
                        'device_password' => $post['device_password'][$k],
                        'power_on' => $post['power_on'][$k],
                        'charging' => $post['charging'][$k],
                        'network' => $post['network'][$k],
                        'display' => $post['display'][$k],
                        'camera' => $post['camera'][$k],
                        'battery' => $post['battery'][$k],
                        'fault_discription' => $post['fault_discription'][$k],
                        'amount' => abs($post['amount'][$k]),
                        'cost' => abs($post['cost'][$k])
                    );                    
                }
                $this->job_model->delete_items_by_id($id);
                $this->job_model->save_items($data);
                $this->session->set_flashdata('success', 'Record has been saved successfully.');
                redirect('job');
            }
        }
        $data['job'] = $this->job_model->get_where(array('id' => $id));
        $data['job'][0]['items'] = $this->job_model->get_items($id);

        $data['brands'] = $this->device_model->get_brands();
        $data['customers'] = $this->customer_model->get_all();
        $data['offices'] = $this->offices;
        $data['page_title'] = 'Bookings';
        $data['template'] = "job/add_edit";
        $this->load->view("master_template", $data);
    }    
 
    public function ajax_delete($id)
    {
        $this->job_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_status_change($id, $status)
    {
        $data['status'] = $status;
        $data['updated_datetime'] = date("Y-m-d H:i:s");

        $this->job_model->update($id, $data);

        ## Send email notification ##
        if($status == 1)
        {
            $email_template = $this->email_model->get_by_id(2); //Order ready
            if(!empty($email_template))
            {
                $from_email = $email_template->from_email;
                $from_name = $email_template->from_name;
                $to_email = $email_template->to_email;
                $subject = $email_template->subject;
                $message = $email_template->message;

                $data = $this->job_model->email_data($id);
    
                $this->fsd->email_template($data, $from_email, $from_name, $to_email, $subject, $message);
                $this->fsd->sent_email($from_email, $from_name, $to_email, $subject, $message );
            }
        }
        ## End sent email ##        
        echo json_encode(array("status" => TRUE));
    }    

    public function ajax_get_model()
    {
        $models = array();
        $brand_id = $this->input->get('brand_id', TRUE);
        if(!empty($brand_id))
        {            
            $models = $this->device_model->get_model_by_brand($brand_id);            
        }
        die( json_encode($models) );

    }

    public function invoice($job_id)
    {
        $data = array();
        $data['job'] = $this->job_model->get_invoice($job_id);
        if($data['job'] < 1)
        {
            $this->session->set_flashdata('error', 'No invoice found.');
            redirect('job');
        }
        $this->load->view("job/invoice", $data);        
    }

    public function recept($job_id)
    {
        $data = array();
        $data['job'] = $this->job_model->get_invoice($job_id);
        if($data['job'] < 1)
        {
            $this->session->set_flashdata('error', 'No invoice found.');
            redirect('job');
        }
        $this->load->view("job/thermal", $data);        
    }    
}