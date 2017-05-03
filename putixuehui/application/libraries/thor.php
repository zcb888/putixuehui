<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CI_Thor {
	function __construct() {
		$this->CI = & get_instance ();
	}
	public function getIp() {
		$onlineip = '';
		if (getenv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( getenv ( 'HTTP_CLIENT_IP' ), 'unknown' )) {
			$onlineip = getenv ( 'HTTP_CLIENT_IP' );
		} elseif (getenv ( 'REMOTE_ADDR' ) && strcasecmp ( getenv ( 'REMOTE_ADDR' ), 'unknown' )) {
			$onlineip = getenv ( 'REMOTE_ADDR' );
		} elseif (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], 'unknown' )) {
			$onlineip = $_SERVER ['REMOTE_ADDR'];
		}
		return $onlineip;
	}
	function loginstate($getpoint, $loginpage = false) {
		$LoggedIN = $this->CI->session->userdata ( 'logged_in' );
		$Point = $this->CI->session->userdata ( 'point' );
		
		// var_dump($LoggedIN);var_dump($Point);var_dump($getpoint);die();
		if ((! $LoggedIN || $getpoint != $Point) && ! $loginpage) {
			switch ($getpoint) {
				case 100 :
					$url = '/index.php/admin/login';
					break;
			}
			echo '<script type="text/javascript"> top.location.href = "' . $url . '"; </script>';
			exit ();
		}
		if ($loginpage && (! $LoggedIN || $getpoint != $Point)) {
			return false;
		}
		return true;
	}
	function loginper($getpoint) {
		$LoggedIN = $this->CI->session->userdata ( 'logged_in' );
		$Point = $this->CI->session->userdata ( 'point' );
		if (! $LoggedIN || $getpoint > $Point) {
			echo '<script type="text/javascript"> top.location.href = "/index.php/admin/login"; </script>';
			exit ();
		}
	}
	function getname() {
		return $this->CI->session->userdata ( 'loginname' );
	}
	function getgroup() {
		return $this->CI->session->userdata ( 'group' );
	}
	function getpoint() {
		return $this->CI->session->userdata ( 'point' );
	}
	
	/**
	 *
	 *
	 *
	 *
	 *
	 * 前台登陆
	 *
	 * @param unknown_type $getpoint        	
	 * @param unknown_type $loginpage        	
	 */
	function webLoginState($getpoint, $loginpage = false) {
		$LoggedIN = $this->CI->session->userdata ( 'weblogged_in' );
		$Point = $this->CI->session->userdata ( 'webpoint' );
		
		// var_dump($LoggedIN);var_dump($Point);var_dump($getpoint);die();
		if ((! $LoggedIN || $getpoint != $Point) && ! $loginpage) {
			switch ($getpoint) {
				case 100 :
					$url = '/index.php/web/login';
					break;
			}
			echo '<script type="text/javascript"> top.location.href = "' . $url . '"; </script>';
			exit ();
		}
		if ($loginpage && (! $LoggedIN || $getpoint != $Point)) {
			return false;
		}
		return true;
	}
	function webLoginper($getpoint) {
		$LoggedIN = $this->CI->session->userdata ( 'weblogged_in' );
		$Point = $this->CI->session->userdata ( 'webpoint' );
		if (! $LoggedIN || $getpoint > $Point) {
			echo '<script type="text/javascript"> top.location.href = "/index.php/login"; </script>';
			exit ();
		}
	}
	function getLoginName() {
		return $this->CI->session->userdata ( 'webloginname' );
	}
	function getLoginUserId() {
		return $this->CI->session->userdata ( 'user_id' );
	}
	function getLoginPoint() {
		return $this->CI->session->userdata ( 'webpoint' );
	}
	
	
	function getUniqueKey() {
		$unique_json = $this->getUniqueUser ();
		return $unique_json->unique_key;
	}
	
	// 获取未登录用户的cookie
	function getUniqueUser() {
		$unique_json = null;
		$this->CI->load->library ( 'des' );
		if (isset ( $_COOKIE ['unique_key'] )) {
			$unique_key_str = $_COOKIE ['unique_key'];
			$json_des_str = $this->CI->des->decrypt ( $unique_key_str );
			$unique_json = json_decode ( $json_des_str );
		} else {
			$unique_key = uniqid ( "xuehui_" . time () . rand ( 1, 10000 ) );
			$user_id = $this->getLoginUserId ();
			$unique_array = array (
					'unique_key' => $unique_key,
					'bid' => 0,
					'name' => '',
					'uid' => 0 
			);
			$json_str = json_encode ( $unique_array );
			$json_des_str = $this->CI->des->encrypt ( $json_str );
			$this->CI->input->set_cookie ( 'unique_key', $json_des_str, 6048000 );
			$unique_json = json_decode ( $json_str );
		}
		return $unique_json;
	}
	
	//设置登录用户id
	function setUniqueUser($bid = 0,$user_id=0,$name ='') {
		$unique_json = null;
		$this->CI->load->library ( 'des' );
		if (isset ( $_COOKIE ['unique_key'] )) {
			$unique_key_str = $_COOKIE ['unique_key'];
			$json_des_str = $this->CI->des->decrypt ( $unique_key_str );
			$unique_json = json_decode ( $json_des_str );
			$unique_json->bid = $bid;
			$unique_json->uid = $user_id;
			$unique_json->name = $name;
			$json_str = json_encode ( $unique_json );
			$json_des_str = $this->CI->des->encrypt ( $json_str );
			$this->CI->input->set_cookie ( 'unique_key', $json_des_str, time()+6048000);
		} else {
			$unique_key = uniqid ( "xuehui_" . time () . rand ( 1, 10000 ) );
			//$user_id = $this->getLoginUserId ();
			$unique_array = array (
					'unique_key' => $unique_key,
					'bid' => $bid,
					'name' => $name,
					'uid' => $user_id 
			);
			$json_str = json_encode ( $unique_array );
			$json_des_str = $this->CI->des->encrypt ( $json_str );
			$this->CI->input->set_cookie ( 'unique_key', $json_des_str, time()+6048000);
		}
	}
	// md5二次加密添加salt值,防止md5被破解
	function getSaltStr() {
		return 'ybnapp'; // 'gongxifacai';
	}
	
	/**
	 * 获取当前访问url
	 * @date 2016-11-22
	 *
	 * @author Gavin
	 */
	function get_url() {
		$sys_protocal = isset ( $_SERVER ['SERVER_PORT'] ) && $_SERVER ['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER ['PHP_SELF'] ? $_SERVER ['PHP_SELF'] : $_SERVER ['SCRIPT_NAME'];
		$path_info = isset ( $_SERVER ['PATH_INFO'] ) ? $_SERVER ['PATH_INFO'] : '';
		$relate_url = isset ( $_SERVER ['REQUEST_URI'] ) ? $_SERVER ['REQUEST_URI'] : $php_self . (isset ( $_SERVER ['QUERY_STRING'] ) ? '?' . $_SERVER ['QUERY_STRING'] : $path_info);
		return $sys_protocal . (isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : '') . $relate_url;
	}

}

?>
