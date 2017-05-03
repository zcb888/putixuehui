<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class CI_Sendemail{
	
	public function send($to,$subject, $message){ 
		try{
			$this->ci = & get_instance();
			$this->ci->load->library('email');
			
			//以下设置Email参数
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'smtp.163.com';
			$config['smtp_user'] = 'xfgamesale';
			$config['smtp_pass'] = '815290048';
			$config['smtp_port'] = '25';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->ci->email->initialize($config);
			
			//以下设置Email内容
			$this->ci->email->from('xfgamesale@163.com', '荻溪资本');
			$this->ci->email->to($to);
			$this->ci->email->subject($subject);
			$this->ci->email->message($message);
			
			$this->ci->email->send();
		}catch(Exception $e){
			//echo $e->getMessage();
		}
	}
}
?>