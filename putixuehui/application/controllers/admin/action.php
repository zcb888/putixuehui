<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Action extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}

	/*
	 * 首页列表
	 */
	public function index() {
		$this->permission->hasAccess ( 'action_index' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$name = trim ( $this->input->get ( 'name' ) );
		$startdate = trim ( $this->input->get ( 'startdate' ) );
		$enddate = trim ( $this->input->get ( 'enddate' ) );
		$url = "/admin/action/index?name=" . $name . "&startdate=" . $startdate . "&enddate=" . $enddate;

		$this->load->model ( 'table/action_model' );

		$group_id = 0;
		$admin_group = $this->thor->getgroup ();
		if ($admin_group > 1) // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
			$group_id = $this->session->userdata ( 'manger_group_id' );
		$list = $this->action_model->search ( $name, $group_id, $startdate, $enddate, $pageindex );
		$count = $this->action_model->search_count ( $name, $group_id, $startdate, $enddate );

		$data = array (
				'name' => $name,
				'startdate' => $startdate,
				'enddate' => $enddate
		);
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 20, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;

		$data ['view'] = 'application/views/admin/action/index';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/*
	 * 编辑
	 */
	function edit($id) {
		if ($id) {
			$this->load->model ( 'table/action_model' );

			$sql = 'select a.*,b.name from action a left join users b on a.user_id=b.id where a.id=' . $id;
			$admin_group = $this->thor->getgroup ();
			if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
				$manger_group_id = $this->session->userdata ( 'manger_group_id' );
				$sql .= " and b.group_id=" . $manger_group_id;
			}
			$model = $this->db->query ( $sql )->first_row ();
			if ($model) {
				$data ['model'] = $model;
				$data ['view'] = 'application/views/admin/action/edit';
				$this->load->view ( 'admin/common/frame', $data );
			}
		}
	}

	/*
	 * 展示
	 */
	function detail($id) {
		if ($id) {
			$this->load->model ( 'table/action_model' );
			$model = $this->action_model->getModelByPrimaryKey ( array (
					'id' => $id
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/action/detail';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}

	/*
	 * 添加
	 */
	public function add() {
		// $this->permission->webHasAccess ( 'action_add' );
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			$user_id = trim ( $this->input->post ( 'user_id' ) );
			$action_date = trim ( $this->input->post ( 'action_date' ) );
			$big_head = trim ( $this->input->post ( 'big_head' ) );
			$small_head = trim ( $this->input->post ( 'small_head' ) );
			// $total_head = trim ( $this->input->post ( 'total_head' ) );

			$remark = trim ( $this->input->post ( 'remark' ) );
			$add_time = date ( 'Y-m-d H:i:s' );

			$total_head = intval ( $big_head ) + intval ( $small_head );

			$wenshu = trim ( $this->input->post ( 'wenshu' ) );
			$huaiye = trim ( $this->input->post ( 'huaiye' ) );
			$guanxiu = trim ( $this->input->post ( 'guanxiu' ) );
			$wenshu = intval ( $wenshu );
			$huaiye = intval ( $huaiye );
			$guanxiu = intval ( $guanxiu );
			if (empty ( $user_id ) || empty ( $action_date ) || empty ( $total_head )) {
				$this->publicverify->jsAlert ( '请完整填写必填字段' );
				exit ();
			}
			$model = $this->db->select ( 'id' )->where ( 'user_id', $user_id )->where ( 'action_date', $action_date )->get ( 'action' )->first_row ();
			if ($model) {
				$this->publicverify->jsAlert ( '提交失败,原因：今天该用户已经提交过了,请修改' );
				exit ();
			} else {
				$this->load->model ( 'table/action_model' );
				$insert_data = array (
						'user_id' => $user_id,
						'action_date' => $action_date,
						'big_head' => $big_head,
						'small_head' => $small_head,
						'total_head' => $total_head,
						'wenshu' => $wenshu,
						'huaiye' => $huaiye,
						'guanxiu' => $guanxiu,
						'remark' => $remark,
						'add_time' => $add_time
				);
				$result = $this->action_model->insert ( $insert_data );
				if ($result > 0) {
					$update_sql = "update users set total_head = total_head + " . $total_head . ",wenshu = wenshu + " . $wenshu . ",huaiye = huaiye + " . $huaiye . " where id=" . $user_id;
					$this->db->query ( $update_sql );
					$this->publicverify->jsAlert ( '提交成功！', 'admin/action/index' );
				} else {
					$this->publicverify->jsAlert ( '提交失败！', 'admin/action/add' );
				}
			}
		}

		$this->db->select ( 'id,name' );
		$admin_group = $this->thor->getgroup ();
		if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能删除自己本组的学员
			$manger_group_id = $this->session->userdata ( 'manger_group_id' );
			$this->db->where ( 'group_id', $manger_group_id );
		}
		$user_list = $this->db->get ( 'users' )->result_array ();
		$data ['user_list'] = $user_list;
		$data ['view'] = 'application/views/admin/action/add';
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
				$user_id = trim ( $this->input->post ( 'user_id' ) );
				$action_date = trim ( $this->input->post ( 'action_date' ) );
				$big_head = trim ( $this->input->post ( 'big_head' ) );
				$small_head = trim ( $this->input->post ( 'small_head' ) );
				// $total_head = trim ( $this->input->post ( 'total_head' ) );
				$remark = trim ( $this->input->post ( 'remark' ) );
				$total_head = intval ( $big_head ) + intval ( $small_head );

				$wenshu = trim ( $this->input->post ( 'wenshu' ) );
				$huaiye = trim ( $this->input->post ( 'huaiye' ) );
				$guanxiu = trim ( $this->input->post ( 'guanxiu' ) );
				$wenshu = intval ( $wenshu );
				$huaiye = intval ( $huaiye );
				$guanxiu = intval ( $guanxiu );
				if (empty ( $action_date ) || empty ( $total_head )) {
					$this->publicverify->jsAlert ( '请完整填写必填字段' );
					exit ();
				}
				$this->load->model ( 'table/action_model' );

				$update_data = array (
						// 'user_id' => $user_id,
						'action_date' => $action_date,
						'big_head' => $big_head,
						'small_head' => $small_head,
						'total_head' => $total_head,
						'wenshu' => $wenshu,
						'huaiye' => $huaiye,
						'guanxiu' => $guanxiu,
						'remark' => $remark
				);
				$result = $this->action_model->update ( $update_data, array (
						'id' => $id
				) );
				if ($result > 0) {
					$update_sql = "update users set total_head=(select sum(total_head) from action where user_id=$user_id),wenshu=(select sum(wenshu) from action where user_id=$user_id),huaiye=(select sum(huaiye) from action where user_id=$user_id) where id=$user_id";
					$this->db->query ( $update_sql );
					$this->publicverify->jsAlert ( '修改成功！', 'admin/action/index' );
				} else {
					$this->publicverify->jsAlert ( '修改失败！', 'admin/action/add' );
				}
			} else {
				$this->publicverify->jsAlert ( '数据异常！！', 'admin/action/index' );
			}
		}
	}

	/*
	 * 删除
	 */
	function del($id) {
		if ($id) {
			$this->load->model ( 'table/action_model' );
			$delete_array ['id'] = $id;
			$is_delete = false;
			$admin_group = $this->thor->getgroup ();
			if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能删除自己本组的学员
				$manger_group_id = $this->session->userdata ( 'manger_group_id' );
				$sql = "select b.id from action a left join users b on a.user_id=b.id where a.id=$id and b.group_id=" . $manger_group_id;
				$model = $this->db->query ( $sql )->first_row ();
				if ($model) {
					$is_delete = true;
				}
			} else {
				$is_delete = true;
			}
			if ($is_delete) {
				$result = $this->action_model->delete ( $delete_array );
				$this->load->library ( 'publicverify' );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '删除成功！', 'admin/action/index' );
				} else {
					$this->publicverify->jsAlert ( '删除失败！', 'admin/action/index' );
				}
			} else {
				$this->publicverify->jsAlert ( '你暂无资格删除该记录！', 'admin/action/index' );
			}
		}
	}

	/*
	 * 周统计报表
	 */
	public function weekreport() {
		$type = $this->input->get ( 'type' );
		$type = empty ( $type ) ? 2 : $type;
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
		}

		$url = "/admin/action/weekreport?";

		$this->load->model ( 'table/action_model' );

		$where_condition = null;
		$admin_group = $this->thor->getgroup ();
		$group_id = 0;
		if ($admin_group > 1) // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
			$group_id = $this->session->userdata ( 'manger_group_id' );

		$list = $this->action_model->search_week ( $group_id, $startdate, $enddate );
		$data ['list'] = $list;
		$data ['startdate'] = $startdate;
		$data ['enddate'] = $enddate;
		$data ['type'] = $type;
		$data ['view'] = 'application/views/admin/action/weekreport';
		$this->load->view ( 'admin/common/frame', $data );
	}
}