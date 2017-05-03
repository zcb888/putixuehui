<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Menumodule extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}
	
	/*
	 * 首页列表
	 */
	public function index() {
		//$this->permission->webHasAccess ( 'company_static_permission_module_index' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$name = trim ( $this->input->get ( 'name' ) );
		$url = "/admin/menumodule/index?name=".$name;
		
		$this->load->model ( 'table/static_permission_module_model' );
		
		$where_condition = array (
		);
		$like_condition = array (
				'name'=>$name
		);
		$sort = array (
				'id' => 'desc' 
		);
		$list = $this->static_permission_module_model->getListByCondition ( $where_condition, $like_condition, $pageindex, $sort );
		$count = $this->static_permission_module_model->getCountByArray ( $where_condition, $like_condition );
		
		$data = array ('name'=>$name);
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 30, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;
		
		$data ['view'] = 'application/views/admin/menumodule/index';
		$this->load->view ( 'admin/common/frame', $data );
	}
	
	/*
	 * 编辑展示
	 */
	function edit($id) {
		if ($id) {
			$this->load->model ( 'table/static_permission_module_model' );
			$model = $this->static_permission_module_model->getModelByPrimaryKey ( array (
					'id' => $id 
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/menumodule/edit';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}
	
	/*
	 * 添加
	 */
	public function add() {
		// $this->permission->webHasAccess ( 'company_static_permission_module_add' );
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			$pid = trim ( $this->input->post ( 'pid' ) );
			$name = trim ( $this->input->post ( 'name' ) );
			$flag = trim ( $this->input->post ( 'flag' ) );
			$url = trim ( $this->input->post ( 'url' ) );
			if (empty ( $pid ) ||empty ( $name ) ||empty ( $flag ) ||empty ( $url )) {
				$this->publicverify->jsAlert ( '请完整填写必填字段' );
				exit ();
			}
			$this->load->model ( 'table/static_permission_module_model' );
			$insert_data = array (
					'pid'=>$pid,
					'name'=>$name,
					'flag'=>$flag,
					'url'=>$url
			);
			$result = $this->static_permission_module_model->insert ( $insert_data );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '提交成功！', 'admin/menumodule/index' );
			} else {
				$this->publicverify->jsAlert ( '提交失败！', 'admin/menumodule/add' );
			}
		}
		$data ['view'] = 'application/views/admin/menumodule/add';
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
				$pid = trim ( $this->input->post ( 'pid' ) );
				$name = trim ( $this->input->post ( 'name' ) );
				$flag = trim ( $this->input->post ( 'flag' ) );
				$url = trim ( $this->input->post ( 'url' ) );
				if (empty ( $pid ) ||empty ( $name ) ||empty ( $flag ) ||empty ( $url )) {
					$this->publicverify->jsAlert ( '请完整填写必填字段' );
					exit ();
				}
				$this->load->model ( 'table/static_permission_module_model' );
				
				$update_data = array (
					'pid'=>$pid,
					'name'=>$name,
					'flag'=>$flag,
					'url'=>$url
				);
				$result = $this->static_permission_module_model->update ( $update_data, array (
						'id' => $id 
				) );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '修改成功！', 'admin/menumodule/index' );
				} else {
					$this->publicverify->jsAlert ( '修改失败！', 'admin/menumodule/add' );
				}
			} else {
				$this->publicverify->jsAlert ( '数据异常！！', 'admin/menumodule/index' );
			}
		}
	}
	
	/*
	 * 删除
	 */
	function del($id) {
		if ($id) {
			$this->load->model ( 'table/static_permission_module_model' );
			$result = $this->static_permission_module_model->delete ( array (
					'id' => $id 
			) );
			$this->load->library ( 'publicverify' );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '删除成功！', 'admin/menumodule/index' );
			} else {
				$this->publicverify->jsAlert ( '删除失败！', 'admin/menumodule/index' );
			}
		}
	}
}