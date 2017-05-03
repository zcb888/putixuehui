<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Users extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}

	/*
	 * 首页列表
	 */
	public function index() {
		$this->permission->hasAccess ( 'users_index' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$name = trim ( $this->input->get ( 'name' ) );
		$phone = trim ( $this->input->get ( 'phone' ) );
		$url = "/admin/users/index?name=" . $name . "&phone=" . $phone;

		$this->load->model ( 'table/users_model' );

		$where_condition = array (
				'name' => $name,
				'phone' => $phone
		);
		$admin_group = $this->thor->getgroup ();
		if ($admin_group > 1) // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
			$where_condition ['group_id'] = $this->session->userdata ( 'manger_group_id' );
		$like_condition = array ();
		$sort = array (
				'id' => 'asc'
		);
		$list = $this->users_model->getListByCondition ( $where_condition, $like_condition, $pageindex, $sort, '*', 20 );
		$count = $this->users_model->getCountByArray ( $where_condition, $like_condition );

		$data = array (
				'name' => $name,
				'phone' => $phone
		);
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 20, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;

		$data ['view'] = 'application/views/admin/users/index';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/*
	 * 编辑
	 */
	function edit($id) {
		if ($id) {
			$this->load->model ( 'table/users_model' );
			$model = null;
			$this->db->where ( 'id', $id );
			$admin_group = $this->thor->getgroup ();
			if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
				$manger_group_id = $this->session->userdata ( 'manger_group_id' );
				$this->db->where ( 'group_id', $manger_group_id );
			}
			$model = $this->db->get ( 'users' )->first_row ();
			if ($model) {
				$data ['model'] = $model;

				$this->db->select ( 'id,name,leader' );
				$admin_group = $this->thor->getgroup ();
				if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
					$manger_group_id = $this->session->userdata ( 'manger_group_id' );
					$this->db->where ( 'id', $manger_group_id );
				}
				$data ['group_list'] = $this->db->get ( 'group' )->result_array ();
				$data ['view'] = 'application/views/admin/users/edit';
				$this->load->view ( 'admin/common/frame', $data );
			} else {
				$this->load->library ( 'publicverify' );
				$this->publicverify->jsAlert ( '你暂无资格修改此用户！', 'admin/users/index' );
			}
		}
	}


	/*
	 * 添加
	 */
	public function add() {
		// $this->permission->webHasAccess ( 'users_add' );
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			$name = trim ( $this->input->post ( 'name' ) );
			$phone = trim ( $this->input->post ( 'phone' ) );
			$password = trim ( $this->input->post ( 'password' ) );
			$email = trim ( $this->input->post ( 'email' ) );
			$group_id = trim ( $this->input->post ( 'group_id' ) );
			$add_time = date ( 'Y-m-d H:i:s' );

			if (empty ( $name ) || empty ( $phone )) {
				$this->publicverify->jsAlert ( '请完整填写必填字段' );
				exit ();
			}
			$new_password = '';
			$salt = $this->thor->getSaltStr ();
			if (empty ( $password )) {
				$new_password = md5 ( md5 ( 123456 ) . $salt );
			} else {
				$new_password = md5 ( md5 ( $password ) . $salt );
			}
			$user_model = $this->db->select ( 'id' )->where ( 'phone', $phone )->get ( 'users' )->first_row ();
			if ($user_model) {
				$this->publicverify->jsAlert ( '该手机号码已经存在[有可能其它小组]，请重新添加！', 'admin/users/add' );
			} else {
				$this->load->model ( 'table/users_model' );
				$insert_data = array (
						'name' => $name,
						'phone' => $phone,
						'password' => $new_password,
						'email' => $email,
						'group_id' => $group_id,
						'add_time' => $add_time
				);
				$result = $this->users_model->insert ( $insert_data );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '提交成功！', 'admin/users/index' );
				} else {
					$this->publicverify->jsAlert ( '提交失败！', 'admin/users/add' );
				}
			}
		}
		$this->db->select ( 'id,name,leader' );
		$admin_group = $this->thor->getgroup ();
		if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
			$manger_group_id = $this->session->userdata ( 'manger_group_id' );
			$this->db->where ( 'id', $manger_group_id );
		}
		$data ['group_list'] = $this->db->get ( 'group' )->result_array ();
		$data ['view'] = 'application/views/admin/users/add';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/*
	 * 编辑保存
	 */
	public function save() {
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			if (isset ( $_POST ['save'] )) {
				$id = $this->input->post ( 'id' );
				$name = trim ( $this->input->post ( 'name' ) );
				$phone = trim ( $this->input->post ( 'phone' ) );
				$password = trim ( $this->input->post ( 'password' ) );
				$email = trim ( $this->input->post ( 'email' ) );
				$group_id = trim ( $this->input->post ( 'group_id' ) );
				if (empty ( $name ) || empty ( $phone )) {
					$this->publicverify->jsAlert ( '请完整填写必填字段' );
					exit ();
				}

				$this->load->model ( 'table/users_model' );

				$update_data = array (
						'name' => $name,
						'phone' => $phone,
						'email' => $email,
						'group_id' => $group_id
				);
				if (! empty ( $password )) {
					$salt = $this->thor->getSaltStr ();
					$new_password = md5 ( md5 ( $password ) . $salt );
					$update_data ['password'] = $new_password;
				}
				$result = $this->users_model->update ( $update_data, array (
						'id' => $id
				) );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '修改成功！', 'admin/users/index' );
				} else {
					$this->publicverify->jsAlert ( '修改失败！', 'admin/users/add' );
				}
			} else {
				$this->publicverify->jsAlert ( '数据异常！！', 'admin/users/index' );
			}
		}
	}

	/**
	 * 导出
	 * @date 2016-11-29
	 *
	 * @author Gavin
	 */
	public function export() {
		$this->db->select ( 'id,name,total_head,phone,email' );

		$admin_group = $this->thor->getgroup ();

		if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
			$manger_group_id = $this->session->userdata ( 'manger_group_id' );
			$this->db->where ( 'group_id', $manger_group_id );
		}
		$data = $this->db->get ( 'users' )->result_array ();
		$this->load->library ( 'excelhelper' );
		$this->excelhelper->push ( $data, 'users_' . date ( 'Ymd' ) );
	}

	/*
	 * 删除
	 */
	function del($id) {
		if ($id) {
			$this->load->model ( 'table/users_model' );
			$delete_array ['id'] = $id;
			$admin_group = $this->thor->getgroup ();

			if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能删除自己本组的学员
				$manger_group_id = $this->session->userdata ( 'manger_group_id' );
				$delete_array ['group_id'] = $manger_group_id;
			}
			$result = $this->users_model->update ( array('group_id'=>4,'status'=>-1), $delete_array);
			// $this->users_model->delete ( $delete_array );
			$this->load->library ( 'publicverify' );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '删除成功！', 'admin/users/index' );
			} else {
				$this->publicverify->jsAlert ( '删除失败！', 'admin/users/index' );
			}
		}
	}

	/*
	 * 首页列表
	 */
	public function reporttop() {
		// $this->permission->webHasAccess ( 'users_index' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$url = "/admin/users/reporttop?";

		$this->load->model ( 'table/users_model' );

		$where_condition = null;
		$admin_group = $this->thor->getgroup ();
		if ($admin_group > 1) // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
			$where_condition ['group_id'] = $this->session->userdata ( 'manger_group_id' );
		$like_condition = array ();
		$sort = array (
				'total_head' => 'desc'
		);
		$list = $this->users_model->getListByCondition ( $where_condition, null, $pageindex, $sort, 'id,name,total_head,wenshu,huaiye', 30 );
		$count = $this->users_model->getCountByArray ( $where_condition, null );

		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 30, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;
		$data ['pageindex'] = $pageindex;
		$data ['view'] = 'application/views/admin/users/reporttop';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/**
	 * 排行榜导出
	 * @date 2016-11-29
	 *
	 * @author Gavin
	 */
	public function topexport() {
		$this->db->select ( 'id,name,total_head,phone,email' );

		$admin_group = $this->thor->getgroup ();

		if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
			$manger_group_id = $this->session->userdata ( 'manger_group_id' );
			$this->db->where ( 'group_id', $manger_group_id );
		}
		$data = $this->db->order_by ( 'total_head desc' )->get ( 'users' )->result_array ();
		$this->load->library ( 'excelhelper' );
		$this->excelhelper->toppush ( $data, 'top_' . date ( 'Ymd' ) );
	}
}