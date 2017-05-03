<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CI_Publicverify {
	private $db;
	private $CI;
	public function __construct() {
		$CI = & get_instance ();
		$this->db = $CI->db;
	}
	
	/*
	 * 验证手机号码
	 */
	function checkPhone($phone) {
		$regex = '/^1[3|4|5|7|8]\d{9}$/';
		return preg_match ( $regex, $phone );
	}
	
	/*
	 * 验证email
	 */
	function checkEmail($email) {
		$regex = '/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/';
		return preg_match ( $regex, $email );
	}
	
	/*
	 * 弹出对话框
	 */
	function jsAlert($message, $url = '') {
		echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
		if ($url)
			echo "<script type='text/javascript'>alert('" . $message . "');parent.location.href ='" . site_url ( $url ) . "';</script>";
		else
			echo "<script type='text/javascript'>alert('" . $message . "');</script>";
		//exit ();
	}
	
	/*
	 * 验证短信
	 */
	function verifySms($telephone, $code, $type) {
		$sql = "SELECT code FROM sms_log  WHERE phone='{$telephone}' and type = {$type} and add_time BETWEEN DATE_ADD(NOW(),INTERVAL -10 MINUTE) AND NOW() ORDER BY add_time DESC LIMIT 1";
	 	$query = $this->db->query($sql);
	 	$result =  $query->first_row();
	 	if($result){
	 		if($result->code == $code)
	 		{
	 			return true;
	 		}else{
	 			return false;
	 		}
	 	}else{
			return false; 
	 	} 
	}
}