<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	/*
 * date:2016-11-14 desc:网站首页 author:Gavin.zhang
 */
class Index extends CI_Controller {
	public $ip = '';
	public $uniquee = '';
	public $is_login = false;
	public $login_user_id = 0;
	public $login_group_id = 0;
	public $login_name = '';
	public function __construct() {
		parent::__construct ();
		// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		$this->init_visit ();
	}
	public function echod() {
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		echo date ( "Ymd", strtotime ( "now" ) ), "\n";
		echo date ( "Ymd", strtotime ( "-1 week Monday" ) ), "\n";
		echo date ( "Ymd", strtotime ( "-1 week Sunday" ) ), "\n";
		echo date ( "Ymd", strtotime ( "+0 week Monday" ) ), "\n";
		echo date ( "Ymd", strtotime ( "+0 week Sunday" ) ), "\n";
		
		// date('n') 第几个月
		// date("w") 本周周几
		// date("t") 本月天数
		
		echo '<br>上周:<br>';
		$next_week_start = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - date ( "w" ) + 1 - 7, date ( "Y" ) ) );
		$next_week_end = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "d" ) - date ( "w" ) + 7 - 7, date ( "Y" ) ) );
		
		echo '<br>本周:<br>';
		$this_week_start = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - date ( "w" ) + 1, date ( "Y" ) ) );
		$this_week_end = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "d" ) - date ( "w" ) + 7, date ( "Y" ) ) );
		
		echo '<br>上月:<br>';
		$next_month_start = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ) - 1, 1, date ( "Y" ) ) );
		$next_month_end = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), 0, date ( "Y" ) ) );
		echo '<br>本月:<br>';
		$this_month_start = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ) ) );
		$this_month_end = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "t" ), date ( "Y" ) ) );
		
		$getMonthDays = date ( "t", mktime ( 0, 0, 0, date ( 'n' ) + (date ( 'n' ) - 1) % 3, 1, date ( "Y" ) ) ); // 本季度未最后一月天数
		echo '<br>本季度:<br>';
		echo date ( 'Y-m-d H:i:s', mktime ( 0, 0, 0, date ( 'n' ) - (date ( 'n' ) - 1) % 3, 1, date ( 'Y' ) ) ), "\n";
		echo date ( 'Y-m-d H:i:s', mktime ( 23, 59, 59, date ( 'n' ) + (date ( 'n' ) - 1) % 3, $getMonthDays, date ( 'Y' ) ) ), "\n";
	}
	
	/**
	 * 首页
	 * @date 2016-11-14
	 *
	 * @author Gavin
	 */
	public function index() {
		if ($this->is_login) {
			$data ['user_id'] = $this->login_user_id;
			$data ['name'] = $this->login_name;
			$group_model = $this->db->select ( 'name' )->where ( 'id', $this->login_group_id )->get ( 'group' )->first_row ();
			$data ['group_name'] = $group_model ? $group_model->name : '';
			$this->load->view ( 'index', $data );
		} else {
			redirect ( 'login' );
		}
	}
	
	/**
	 * 登录
	 * @date 2016-12-07
	 *
	 * @author Gavin
	 */
	public function login() {
		if ($this->is_login)
			redirect ( 'index' );
		if ($_POST) {
			$phone = $this->input->post ( "phone" );
			$password = $this->input->post ( "password" );
			$this->load->library ( 'publicverify' );
			if (empty ( $phone )) {
				$this->publicverify->jsAlert ( '登录失败,原因：手机号不能为空', 'login' );
				exit ();
			} else if (empty ( $password )) {
				$this->publicverify->jsAlert ( '登录失败,原因：登录密码不能为空', 'login' );
				exit ();
			} else {
				$this->db->where ( 'phone', $phone );
				$model = $this->db->get ( 'users' )->row ();
				if ($model) {
					$salt = $this->thor->getSaltStr ();
					if (strtolower ( $model->password ) == strtolower ( md5 ( md5 ( $password ) . $salt ) )) {
						if ($model->status < 2) {
							$this->thor->setUniqueUser ( $model->group_id, $model->id, $model->name );
							redirect ( 'index' );
						} else {
							$this->publicverify->jsAlert ( '登录失败,原因：账户已被锁定', 'login' );
							exit ();
						}
					} else {
						$this->publicverify->jsAlert ( '登录失败,原因：登录密码不匹配', 'login' );
						exit ();
					}
				} else {
					$this->publicverify->jsAlert ( '登录失败,原因：用户不存在', 'login' );
					exit ();
				}
			}
		}
		// $user_list = $this->db->select ( 'id,name' )->get ( 'users' )->result_array ();
		// $data ['user_list'] = $user_list;
		
		$this->load->view ( 'login' );
	}
	
	/**
	 * 退出
	 * @date 2016-12-07
	 *
	 * @author Gavin
	 */
	public function logout() {
		$this->thor->setUniqueUser ( 0, 0, '' );
		$this->is_login = false;
		redirect ( 'login' );
	}
	
	/**
	 * 修改密码
	 * @date 2016-12-8
	 *
	 * @author Gavin
	 */
	public function changepwd() {
		if ($this->is_login) {
			if ($_POST) {
				$user_id = $this->input->post ( 'user_id' );
				$old_password = trim ( $this->input->post ( 'old_password' ) );
				$password = trim ( $this->input->post ( 'password' ) );
				$confirm_password = trim ( $this->input->post ( 'confirm_password' ) );
				$this->load->library ( 'publicverify' );
				if (empty ( $user_id ) || empty ( $old_password ) || empty ( $password ) || empty ( $confirm_password )) {
					$this->publicverify->jsAlert ( '修改失败,原因：以上全部为必填项', 'index/changepwd' );
					exit ();
				}
				if ($password != $confirm_password) {
					$this->publicverify->jsAlert ( '修改失败,原因：两次输入密码不一致', 'index/changepwd' );
					exit ();
				}
				$salt = $this->thor->getSaltStr ();
				$md5_old_password = strtolower ( md5 ( md5 ( $old_password ) . $salt ) );
				$user_model = $this->db->select ( 'id' )->where ( 'id', $user_id )->where ( 'password', $md5_old_password )->get ( 'users' )->first_row ();
				if ($user_model) {
					$md5_pasword = strtolower ( md5 ( md5 ( $password ) . $salt ) );
					$result = $this->db->where ( 'id', $user_id )->update ( 'users', array (
							'password' => $md5_pasword 
					) );
					if ($result > 0) {
						$this->publicverify->jsAlert ( '修改成功，请重新用新密码登录', 'index/logout' );
						exit ();
					} else {
						$this->publicverify->jsAlert ( '修改失败,原因：参数异常', 'index/changepwd' );
						exit ();
					}
				} else {
					$this->publicverify->jsAlert ( '修改失败,原因：原密码输入不正确', 'index/changepwd' );
					exit ();
				}
				// redirect ( 'index' );
			} else {
				$data ['user_id'] = $this->login_user_id;
				$data ['name'] = $this->login_name;
				$this->load->view ( 'changepwd', $data );
			}
		} else {
			redirect ( 'login' );
		}
	}
	
	/**
	 * 结果页面
	 * @date 2016-11-14
	 *
	 * @author Gavin
	 */
	public function result() {
		if ($_POST) {
			$user_id = $this->input->post ( 'user_id' );
			$action_date = trim ( $this->input->post ( 'action_date' ) );
			$big_head = trim ( $this->input->post ( 'big_head' ) );
			$small_head = trim ( $this->input->post ( 'small_head' ) );
			$remark = trim ( $this->input->post ( 'remark' ) );
			$total_count = intval ( $big_head ) + intval ( $small_head );
			
			$wenshu = trim ( $this->input->post ( 'wenshu' ) );
			$huaiye = trim ( $this->input->post ( 'huaiye' ) );
			$guanxiu = trim ( $this->input->post ( 'guanxiu' ) );
			$wenshu = intval ( $wenshu );
			$huaiye = intval ( $huaiye );
			$guanxiu = intval ( $guanxiu );
			
			$temp_count = $total_count + $wenshu + $huaiye;
			$this->load->library ( 'publicverify' );
			if (empty ( $user_id )) {
				$this->publicverify->jsAlert ( '提交失败,原因：未选择姓名', 'index' );
				exit ();
			}
			if ($temp_count == 0) {
				$this->publicverify->jsAlert ( '提交失败,原因：数量不能全部为0', 'index' );
				exit ();
			}
			if (empty ( $action_date )) {
				$this->publicverify->jsAlert ( '提交失败,原因：未填写日期', 'index' );
				exit ();
			}
			$model = $this->db->select ( 'id' )->where ( 'user_id', $user_id )->where ( 'action_date', $action_date )->get ( 'action' )->first_row ();
			if ($model) {
				$this->publicverify->jsAlert ( '提交失败,原因：今天您已经提交过了，如需修改请联系组长', 'index' );
				exit ();
			} else {
				$insert_data = array (
						'user_id' => $user_id,
						'action_date' => $action_date,
						'big_head' => intval ( $big_head ),
						'small_head' => intval ( $small_head ),
						'total_head' => $total_count,
						'wenshu' => $wenshu,
						'huaiye' => $huaiye,
						'guanxiu' => $guanxiu,
						'remark' => $remark,
						'ip' => $this->ip,
						'uniquee' => $this->uniquee,
						'add_time' => date ( 'Y-m-d H:i:s' ) 
				);
				$this->db->insert ( 'action', $insert_data );
				$update_sql = "update users set total_head = total_head + " . $total_count . ",wenshu = wenshu + " . $wenshu . ",huaiye = huaiye + " . $huaiye . ",ip='$this->ip',uniquee='$this->uniquee' where id=" . $user_id;
				$this->db->query ( $update_sql );
			}
		}
		if ($this->is_login) {
			$date = $this->input->get ( 'date' );
			$user_id = $this->input->get ( 'user_id' );
			$date = empty ( $date ) ? date ( 'Y-m-d' ) : $date;
			$sql = "select a.user_id,b.name,a.big_head,a.small_head,a.total_head,a.wenshu,a.huaiye from action a left join users b on a.user_id=b.id where b.group_id=" . $this->login_group_id . " and a.action_date='$date'";
			if ($user_id)
				$sql .= " and a.user_id=" . $user_id;
			$action_list = $this->db->query ( $sql )->result_array ();
			$data ['date'] = $date;
			$data ['action_list'] = $action_list;
			
			$unsubmit_name = $this->get_unsubmit_str ( $action_list, $this->login_group_id );
			$group_model = $this->db->select ( 'name' )->where ( 'id', $this->login_group_id )->get ( 'group' )->first_row ();
			$data ['unsubmit_name'] = $unsubmit_name;
			$data ['group_name'] = $group_model ? $group_model->name : '';
			$this->load->view ( 'result', $data );
		} else {
			redirect ( 'login' );
		}
	}
	private function get_unsubmit_str($action_list, $group_id) {
		$return_str = '';
		$action_user_array = array ();
		if ($action_list) {
			foreach ( $action_list as $item ) {
				$action_user_array [] = $item ['user_id'];
			}
		}
		$user_list = $this->db->select ( 'id,name' )->where ( 'group_id', $group_id )->get ( 'users' )->result_array ();
		if ($user_list) {
			foreach ( $user_list as $item ) {
				if (! in_array ( $item ['id'], $action_user_array ))
					$return_str .= $item ['name'] . '、';
			}
		}
		return $return_str;
	}
	
	/**
	 * 排行榜
	 * @date 2017-1-17
	 *
	 * @author Gavin
	 */
	public function top() {
		if ($this->is_login) {
			$group_model = $this->db->select ( 'name' )->where ( 'id', $this->login_group_id )->get ( 'group' )->first_row ();
			$data ['group_name'] = $group_model ? $group_model->name : '';
			
			$data ['list'] = $this->db->query ( 'select id,name,total_head,wenshu,huaiye from users where group_id=' . $this->login_group_id . ' order by total_head desc limit 100' )->result_array ();
			
			$this->load->view ( 'top', $data );
		} else {
			redirect ( 'login' );
		}
	}
	
	/*
	 * 个人详细
	 */
	public function detail() {
		if ($this->is_login) {
			$pageindex = $this->input->get ( 'per_page' );
			$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
			$user_id = trim ( $this->input->get ( 'user_id' ) );
			
			$type = $this->input->get ( 'type' );
			//$type = empty ( $type ) ? 2 : $type;
			$startdate = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ) ) );
			$enddate = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "t" ), date ( "Y" ) ) );
			switch ($type) {
				case 1 :
					$startdate = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - date ( "w" ) + 1 - 7, date ( "Y" ) ) );
					$enddate = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "d" ) - date ( "w" ) + 7 - 7, date ( "Y" ) ) );
					break;
				case 2 :
					$startdate = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - date ( "w" ) + 1, date ( "Y" ) ) );
					$enddate = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "d" ) - date ( "w" ) + 7, date ( "Y" ) ) );
					break;
				case 3 :
					$startdate = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ) - 1, 1, date ( "Y" ) ) );
					$enddate = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), 0, date ( "Y" ) ) );
					break;
				case 4 :
					$startdate = date ( "Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ) ) );
					$enddate = date ( "Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "t" ), date ( "Y" ) ) );
					break;
				default :
					$startdate = null;
					$enddate = null;
			}
			
			$url = "/index/detail?user_id=" . $user_id . "&type=" . $type;
			
			$this->load->model ( 'table/action_model' );
			
			$list = $this->action_model->search_detail ( $user_id, $startdate, $enddate, $pageindex );
			$count = $this->action_model->search_detail_count ( $user_id, $startdate, $enddate );
			
			// $data = array (
			// 'user_id' => $user_id
			// );
			$this->load->library ( 'pagination' );
			$config = $this->fun->page ( $url, $count, 20, $url, 4 );
			$config ['page_query_string'] = TRUE;
			$this->pagination->initialize ( $config );
			$data ['model'] = $this->db->select ( 'id,name,total_head,wenshu,huaiye' )->where ( 'id', $user_id )->get ( 'users' )->first_row ();
			
			$data ['pagination'] = $this->pagination->create_links ();
			$data ['list'] = $list;
			
			$this->load->view ( 'detail', $data );
		} else {
			redirect ( 'login' );
		}
	}
	
	/**
	 * 初始化访问方法
	 * @date 2016-11-21
	 *
	 * @author Gavin
	 */
	private function init_visit() {
		$unique_json = $this->thor->getUniqueUser ();
		if ($unique_json) {
			$this->uniquee = $unique_json->unique_key;
			$this->is_login = empty ( $unique_json->uid ) ? false : true;
			$this->login_user_id = empty ( $unique_json->uid ) ? 0 : $unique_json->uid;
			$this->login_group_id = empty ( $unique_json->bid ) ? 0 : $unique_json->bid;
			$this->login_name = empty ( $unique_json->name ) ? '' : $unique_json->name;
		}
		$visit_url = $this->thor->get_url ();
		$this->load->library ( 'location' );
		$visit_ip = $this->location->getIp ();
		$this->ip = $visit_ip;
	}
}