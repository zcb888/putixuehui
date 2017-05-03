<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Usergroup extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}
	
	/*
	 * 首页列表
	 */
	public function index() {
	    $this->permission->hasAccess ( 'usergroup' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$name = trim ( $this->input->get ( 'name' ) );
		$leader = trim ( $this->input->get ( 'leader' ) );
		$url = "/admin/users/index?name=" . $name . "&leader=" . $leader;
		
		$this->load->model ( 'table/group_model' );
		
		$where_condition = array (
				'name' => $name,
				'leader' => $leader 
		);
		$like_condition = array ();
		$sort = array (
				'id' => 'asc' 
		);
		$list = $this->group_model->getListByCondition ( $where_condition, $like_condition, $pageindex, $sort, '*', 20 );
		$count = $this->group_model->getCountByArray ( $where_condition, $like_condition );
		
		$data = array (
				'name' => $name,
				'leader' => $leader 
		);
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 20, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;
		
		$data ['view'] = 'application/views/admin/usergroup/index';
		$this->load->view ( 'admin/common/frame', $data );
	}
	
	/*
	 * 编辑
	 */
	function edit($id) {
		if ($id) {
			$this->load->model ( 'table/group_model' );
			$model = $this->group_model->getModelByPrimaryKey ( array (
					'id' => $id 
			) );
			
			$area_array = array (
					'province' => $model->province_id,
					'city' => $model->city_id,
					'district' => $model->district_id
			);
			$this->load->model ( 'table/region' );
			$data = $this->region->getAreaHTML ($area_array, null );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/usergroup/edit';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}
	
	/*
	 * 添加
	 */
	public function add() {
		$this->load->model ( 'table/region' );
		$data = $this->region->getAreaHTML ( '', null );
		
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			$name = trim ( $this->input->post ( 'name' ) );
			$leader = trim ( $this->input->post ( 'leader' ) );
			$province = trim ( $this->input->post ( 'province' ) );
			$city = trim ( $this->input->post ( 'city' ) );
			$district = trim ( $this->input->post ( 'district' ) );
			$address = trim ( $this->input->post ( 'address' ) );
			$add_time = date ( 'Y-m-d H:i:s' );
			
			if (empty ( $name ) || empty ( $leader )) {
				$this->publicverify->jsAlert ( '请完整填写必填字段' );
				exit ();
			}
			$this->load->model ( 'table/group_model' );
			$insert_data = array (
					'name' => $name,
					'leader' => $leader,
					'province_id' => $province,
					'city_id' => $city,
					'district_id' => $district,
					'address'=>$address,
					'add_time' => $add_time 
			);
			$result = $this->group_model->insert ( $insert_data );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '提交成功！', 'admin/usergroup/index' );
			} else {
				$this->publicverify->jsAlert ( '提交失败！', 'admin/usergroup/add' );
			}
		}
		$data ['view'] = 'application/views/admin/usergroup/add';
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
				$leader = trim ( $this->input->post ( 'leader' ) );
				$province = trim ( $this->input->post ( 'province' ) );
				$city = trim ( $this->input->post ( 'city' ) );
				$district = trim ( $this->input->post ( 'district' ) );
				$address = trim ( $this->input->post ( 'address' ) );
				if (empty ( $name ) || empty ( $leader )) {
					$this->publicverify->jsAlert ( '请完整填写必填字段' );
					exit ();
				}
				$this->load->model ( 'table/group_model' );
				
				$update_data = array (
						'name' => $name,
						'leader' => $leader,
						'province_id' => $province,
						'city_id' => $city,
						'district_id' => $district,
						'address'=>$address
				);
				$result = $this->group_model->update ( $update_data, array (
						'id' => $id 
				) );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '修改成功！', 'admin/usergroup/index' );
				} else {
					$this->publicverify->jsAlert ( '修改失败！', 'admin/usergroup/add' );
				}
			} else {
				$this->publicverify->jsAlert ( '数据异常！！', 'admin/usergroup/index' );
			}
		}
	}
	
	/*
	 * 删除
	 */
	function del($id) {
		if ($id) {
			$this->load->model ( 'table/group_model' );
			$result = $this->group_model->delete ( array (
					'id' => $id 
			) );
			$this->load->library ( 'publicverify' );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '删除成功！', 'admin/usergroup/index' );
			} else {
				$this->publicverify->jsAlert ( '删除失败！', 'admin/usergroup/index' );
			}
		}
	}
}