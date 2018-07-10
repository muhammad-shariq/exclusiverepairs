<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * FSD Library By Shariq
 */
class Fsd
{	
	public function __construct() 
	{
		$this->CI =& get_instance();
		$this->CurrencyCode = array(
			'USD' => '$', 
			'GBP' => '&pound;', 
			'EUR' => '&euro;' 
		); 	
	}
	
	public function sent_email($from_email, $from_name, $to_email, $subject, $message, $attachments = array() )
	{
		$this->CI->load->library('email');		
		$config['mailtype'] = 'html';

        $config['protocol'] = 'mail';
        $config['smtp_timeout'] = 5;
		$config['charset']='utf-8'; // Default should be utf-8 (this should be a text field) 
		$config['newline']="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
		$config['crlf'] = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n"    
		
		$this->CI->email->initialize($config);
		
		$this->CI->email->from($from_email, $from_name);
		$this->CI->email->to($to_email);		
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);
		
		if(count($attachments)>0)
		{
			foreach ($attachments as $field_name) 
			{
				$upload_path = $this->CI->config->item('upload_email_dir');
				$allowed_types = 'psd|eps|ai|tiff|jpg|gif|png|doc|xls|docx|xlsx|zip';
				$data = $this->do_upload($field_name, $upload_path, $allowed_types);
				if(!isset($data['error']))
				{
					$this->CI->email->attach($data['upload_data']['file_path'].$data['upload_data']['file_name']);	
				}	
			}		
		}		
		return $this->CI->email->send();		
		//echo $this->CI->email->print_debugger(); exit;
	}

	public function do_upload($field_name, $upload_path, $allowed_types = 'gif|jpg|png')
	{
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = $allowed_types;
		$config['max_size']	= '20480'; //in KB

		$this->CI->load->library('upload', $config);

		if ( ! $this->CI->upload->do_upload($field_name))
		{
			return array('error' => $this->CI->upload->display_errors());
		}
		else
		{
			return array('upload_data' => $this->CI->upload->data());
		}
	}
	
	public function email_template($post, &$from_email, &$from_name,&$to_email, &$subject, &$message)
	{
		$this->CI->load->model('email_model');
		$tags = array();
		$values  = array();
		
		$data = $this->CI->email_model->get_all_tags();
		foreach ($data as $v) 
		{
			if(isset($post[$v['field_name']]))
			{
				$tags[] = $v['tag'];
				$values[] = $post[$v['field_name']];				
			}
		}
		$from_name = str_replace($tags, $values, $from_name);
		$from_email = str_replace($tags, $values, $from_email);
		$to_email = str_replace($tags, $values, $to_email);
		$subject = str_replace($tags, $values, $subject);
		$message = str_replace($tags, $values, $message);
		$message = nl2br($message);		
	}
    
    /**
    * geoip_lookup
    *
    * Looks up GeoIP data from database.
    *
    * @access	public
    * @param	string	$ip    	The either a dotted decimal or integer or the ip address to lookup
    * @return	string      	The two letter country code of the ip address.
    */    
    public function geoip_lookup($ip)
    {
        $s = file_get_contents('http://ip2c.org/'.ip2long($ip));
        if($s[0] == '1')
        {
            $reply = explode(';',$s);
            return $reply[1];
        }
    
        /*// If we are passed a string ip address convert it to a Long Integer
        $data = (is_string($ip)) ? ip2long($ip) : $ip;
        
        $res = mysql_query('SELECT `G`.`country_code` FROM `geoip` AS `G` WHERE ' . $data . ' BETWEEN `G`.`ipnum_start` AND `G`.`ipnum_end` ORDER BY `G`.`country_code` ASC LIMIT 0 , 1');
        if (mysql_num_rows($res)>0) 
        {
            $row = mysql_fetch_array($res);
            return (string) $row['country_code'];
        }*/
        
        return FALSE; 
    }    
}
