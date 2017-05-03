<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	/*
 * date:2014-09-10 desc:管理员登陆 author:Gavin.zhang
 */
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct ();
	}
	
	public function index() {
		if ($_POST) {
			session_start ();
			$username = $this->input->post ( "user" );
			$password = $this->input->post ( "pass" );
			$captcha = $this->input->post ( 'captcha' );
			$is_validate = false;
			if (empty ( $username )) {
				echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
				echo "<script type='text/javascript'>alert('登录帐号不能为空');parent.window.location ='" . site_url ( "admin/login" ) . "';</script>";
				exit ();
			}
			if (empty ( $password )) {
				echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
				echo "<script type='text/javascript'>alert('登录密码不能为空');parent.window.location ='" . site_url ( "admin/login" ) . "';</script>";
				exit ();
			}
// 			if (strtolower ( $captcha ) != strtolower ( $_SESSION ['security_code'] )) {
// 				echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
// 				echo "<script type='text/javascript'>alert('验证码不正确！');parent.window.location ='" . site_url ( "admin/login" ) . "';</script>";
// 				exit ();
// 			}
			$this->db->where ( 'username', $username );
			$model = $this->db->get ( 'static_admin' )->row ();
			if ($model) {
				$salt = $this->thor->getSaltStr ();
				if (strtolower ( $model->password ) == strtolower ( md5 ( md5 ( $password ) . $salt ) )) {
					$is_validate = true;
				}
			}
			if ($is_validate) {
				$this->input->set_cookie ( 'eu', $username, 31536000 );
				$this->db->where ( 'username', $username );
				$user = $this->db->get ( 'static_admin' )->result_array ();
				$eData = array (
						'loginname' => $username,
						'point' => 100,
						'logged_in' => TRUE,
						'manger_group_id'=>$user[0]['manger_group_id'],
						'user_id' => $user [0] ['id'],
						'group' => $user[0]['permission'],
						'name' => $user [0] ['name'] 
				);
				$url = "admin/users/reporttop";
				$this->session->set_userdata ( $eData );
				echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
				echo "<script type='text/javascript'>parent.window.location ='" . site_url ( $url ) . "';</script>";
			} else {
				echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
				echo "<script type='text/javascript'>alert('用户名和密码不匹配');parent.window.location ='" . site_url ( "admin/login" ) . "';</script>";
				exit ();
			}
		} else {
			$this->load->view ( 'admin/login', array (
					'eu' => $this->input->cookie ( 'eu' ),
					'pass' => $this->input->cookie ( 'pass' ) 
			) );
		}
	}

	public function logout() {
		$this->load->helper ( 'url' );
		$this->session->unset_userdata ( 'username' );
		$this->session->unset_userdata ( 'logged_in' );
		redirect ( '/admin/login' );
	}
}