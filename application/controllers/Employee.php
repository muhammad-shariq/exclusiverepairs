<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends FSD_Controller
{
	var $before_filter = array('name' => 'authorization', 'except' => array('login', 'forgot_password'));
	var $offices = array();
    
	public function __construct()
	{
		parent::__construct();
		$this->load->model('employee_model');
        $this->load->model('geo_model');
        $this->offices = $this->geo_model->get_all_offices();

        ## Only Admin Allow funcations ##
        $f = array('office', 'ajax_edit', 'ajax_add', 'ajax_update', 'ajax_delete');
        if (!$this->session->is_admin && in_array($this->router->method, $f)) 
        {
            show_error('You are not authorized to access this page.', 403);
        }
	}

	public function index()
	{
        $data['offices'] = $this->offices;
		$data['page_title'] = 'Employees';
		$data['template'] = "employee/listing";
		$this->load->view("master_template", $data);
	}   
	
	public function dashboard()
	{
        $this->load->model('customer_model');
        $this->load->model('job_model');

        $data['total_customers'] = $this->customer_model->count_all();
        $data['total_jobs'] = $this->job_model->count_all();
        $data['pending_jobs'] = $this->job_model->count_by_status(0);
        $data['ready_jobs'] = $this->job_model->count_by_status(1);
        $data['weekly_stats'] = $this->job_model->get_weekly_profit();

        $data['offices'] = $this->offices;
        $data['page_title'] = 'Dashboard';
		$data['template'] = "dashboard";
		$this->load->view("master_template",$data);
	}

	public function login()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');

		if ($this->form_validation->run() !== FALSE)
		{
			$result = $this->employee_model->get_where(
						array(
							'username' => $this->input->post('username'),
							'password' => $this->input->post('password'),
							'status' => 1
						)
					);
			
			if (count($result)>0)
			{
				$data = array(
                    'employee_id' => $result[0]["id"],
                    'office_id' => $result[0]["office_id"],                    
					'name' => $result[0]["name"],
                    'email' => $result[0]["email"],
                    'is_admin' => $result[0]["is_admin"],
                    'is_logged_in' => TRUE
				);
				$this->session->set_userdata($data);
				
				if($this->input->post('return_url')!="")
					redirect($this->input->post('return_url'));
				else
					redirect("dashboard");
			}
			else
			{
				$this->session->set_flashdata("error", "Invalid username or password");
				redirect("login");
			}
		}
        $this->load->view("login");
	}

	public function forgot_password()
	{ 
        $this->load->model('email_model');
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email|min_length[4]');
		if($this->form_validation->run() !== FALSE)
		{
			$email = $this->input->post('Email',TRUE);
            $data = $this->employee_model->get_where(array('Email'=> $email, 'Status' => '1'));
            if(count($data)>0)
			{
                ## Send email notification ##
                $email_template = $this->email_model->get_by_id(3); //Forgot Password
                if(!empty($email_template))
                {
                    $from_email = $email_template->from_email;
                    $from_name = $email_template->from_name;
                    $to_email = $email_template->to_email;
                    $subject = $email_template->subject;
                    $message = $email_template->message;

                    $this->fsd->email_template($data[0], $from_email, $from_name, $to_email, $subject, $message);
                    $this->fsd->sent_email($from_email, $from_name, $to_email, $subject, $message );
                }
                ## End sent email ##

                $this->session->set_flashdata("success", "Your account information has been sent to your email address.");
				redirect('login');
			}
            $this->session->set_flashdata("error", "Wrong email address.");
            if( $this->session->userdata('is_logged_in') !==  TRUE)
                redirect('login?action=forgot_password');
            else
                redirect('dashboard');
		}
		redirect('login');
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
    
    public function office()
    {
        $id = $this->input->get('office_id');
        $this->session->set_userdata('office_id', $id);
        $return_url = $this->input->get('return_url');
        redirect($return_url);
    }
    
	/**
	 * Change Password of Employee
	 *
	 * Validate and change admin password
	 *
	 * @param	post
	 * @return	void
	 * @author	Muhammad Shariq
	 */	 
	public function change_password()
	{
		if($this->input->method(TRUE) === 'POST')
		{
            $return_url = $this->input->post('return_url', TRUE);
            
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password' , 'Password' ,'trim|required|alpha_numeric|min_length[3]|max_length[15]');
			$this->form_validation->set_rules('re-password' , 'Password Confirmation' ,'trim|required|matches[password]');
			if($this->form_validation->run() !== FALSE)
			{
				$data['password'] = $this->input->post('password', TRUE);
				$data['updated_datetime'] = date("Y-m-d H:i:s");
				
				$this->employee_model->update($data, $this->session->employee_id);
				$this->session->set_flashdata('success', 'Password has been changed successfully.');
				redirect($return_url);
			}
			$this->session->set_flashdata('error', 'Password may contains only alpha numeric values.');
			redirect($return_url);
		}
		show_404();
	}
	
	public function ajax_list()
    {
        $list = $this->employee_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $email_template) {
            $no++;
            $row = array();
            $row[] = $email_template->name;
            $row[] = $email_template->phone;
            $row[] = $email_template->email;
            $row[] = $email_template->username;
            $row[] = $email_template->status?'Active':'Suspended';
            $row[] = $email_template->updated_datetime;
 
            //add html for action
            if($this->session->is_admin)
            {
                $row[] = '<button class="btn btn-xs btn-primary" onclick="edit('."'".$email_template->id."'".')"><i class="fa fa-pencil"></i> Edit</button>
                          <button class="btn btn-xs btn-danger" onclick="del('."'".$email_template->id."'".')"><i class="fa fa-trash"></i> Delete</a>';
            }
    
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->employee_model->count_all(),
                        "recordsFiltered" => $this->employee_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->employee_model->get_by_id($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = $this->input->post(NULL, TRUE);
        if(isset($data['id']))
            unset($data['id']); 
		$data['updated_datetime'] = date("Y-m-d H:i:s");
		$data['created_datetime'] = date("Y-m-d H:i:s");
        $insert = $this->employee_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = $this->input->post(NULL, TRUE);
		$data['updated_datetime'] = date("Y-m-d H:i:s");
        $this->employee_model->update($data['id'], $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        if($id != 1)
        {
            $this->employee_model->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        }
        else
        {
            echo json_encode(array("status" => FALSE));            
        }        
    } 
 
    private function _validate()
    {
        $data = array();
        $post = $this->input->post(NULL, TRUE);
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($post['name'] == '')
        {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }
        elseif (strlen($post['name']) > 255) 
        {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Name can not be grather then 255 characters.';
            $data['status'] = FALSE;
        }        
 
        if($post['phone'] == '')
        {
            $data['inputerror'][] = 'phone';
            $data['error_string'][] = 'Phone is required';
            $data['status'] = FALSE;
        }
        elseif (strlen($post['phone']) > 32) 
        {
            $data['inputerror'][] = 'phone';
            $data['error_string'][] = 'Phone can not be grather then 32 characters.';
            $data['status'] = FALSE;
        }         
 
        if($post['email'] == '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }
        elseif(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === FALSE)
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Invalid email address.';
            $data['status'] = FALSE;	
        }
        elseif (strlen($post['email']) > 64) 
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email can not be grather then 64 characters.';
            $data['status'] = FALSE;
        }
        else 
        {
        	if(isset($post['id']) && !empty($post['id']))
        		$res = $this->employee_model->get_where(array('email' => $post['email'], 'id <>' => $post['id']));
        	else
        		$res = $this->employee_model->get_where(array('email' => $post['email']));
        	if(is_array($res) && count($res) > 0)
        	{
	            $data['inputerror'][] = 'email';
	            $data['error_string'][] = 'Email address already exist`.';
	            $data['status'] = FALSE;        		
        	}
        }

        if($post['username'] == '')
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username is required';
            $data['status'] = FALSE;
        }
        elseif (strlen($post['username']) > 32) 
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username can not be grather then 32 characters.';
            $data['status'] = FALSE;
        } 

        if($post['password'] == '')
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password is required';
            $data['status'] = FALSE;
        }
        elseif (strlen($post['password']) > 32) 
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password can not be grather then 32 characters.';
            $data['status'] = FALSE;
        }
        if($post['id'] == '1' && $post['is_admin'] == '0')
        {
            $data['inputerror'][] = 'is_admin';
            $data['error_string'][] = 'This admin can not be normal employee.';
            $data['status'] = FALSE;
        }                         
        if($post['id'] == '1' && $post['status'] == '0')
        {
            $data['inputerror'][] = 'status';
            $data['error_string'][] = 'This admin can not be suspended.';
            $data['status'] = FALSE;
        }
        if(empty($post['office_id']))
        {
            $data['inputerror'][] = 'office_id';
            $data['error_string'][] = 'Location is required.';
            $data['status'] = FALSE;
        }         

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }                
}