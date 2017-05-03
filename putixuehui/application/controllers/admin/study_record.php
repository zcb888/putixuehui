<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Study_record extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}


	/*
	 * 首页列表
	 */
	public function index() {
		//$this->permission->webHasAccess ( 'study_record_index' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$name = trim ( $this->input->get ( 'name' ) );
		$group_id = trim ( $this->input->get ( 'group_id' ) );
		$is_all_ok = trim ( $this->input->get ( 'is_all_ok' ) );
		$url = "/admin/study_record/index?name=".$name."&group_id=".$group_id."&is_all_ok=".$is_all_ok;

		$this->load->model ( 'table/study_record_model' );

		$where_condition = array (
				'name'=>$name,
				'group_id'=>$group_id,
				'is_all_ok'=>$is_all_ok
		);
		$like_condition = array (
		);
		$sort = array (
				'id' => 'desc'
		);
		$list = $this->study_record_model->getListByCondition ( $where_condition, $like_condition, $pageindex, $sort,'*',20 );
		$count = $this->study_record_model->getCountByArray ( $where_condition, $like_condition );

		$data = array ('name'=>$name,'group_id'=>$group_id,'is_all_ok'=>$is_all_ok);
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 20, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;

		$data ['view'] = 'application/views/admin/study_record/index';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/*
	 * 编辑
	 */
	function edit($id) {
		if ($id) {
			$this->load->model ( 'table/study_record_model' );
			$model = $this->study_record_model->getModelByPrimaryKey ( array (
					'id' => $id
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/study_record/edit';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}


/*
 * 展示
*/
	function detail($id) {
		if ($id) {
			$this->load->model ( 'table/study_record_model' );
			$model = $this->study_record_model->getModelByPrimaryKey ( array (
					'id' => $id
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/study_record/detail';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}

	/*
	 * 添加
	 */
	public function add() {
		// $this->permission->webHasAccess ( 'study_record_add' );
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			$user_id = trim ( $this->input->post ( 'user_id' ) );
			$name = trim ( $this->input->post ( 'name' ) );
			$group_id = trim ( $this->input->post ( 'group_id' ) );
			$chapter_id = trim ( $this->input->post ( 'chapter_id' ) );
			$is_join = trim ( $this->input->post ( 'is_join' ) );
			$is_all_ok = trim ( $this->input->post ( 'is_all_ok' ) );
			$all_ok_date = trim ( $this->input->post ( 'all_ok_date' ) );
			$operation_user_id = trim ( $this->input->post ( 'operation_user_id' ) );
			$is_licence = trim ( $this->input->post ( 'is_licence' ) );
			$reason = trim ( $this->input->post ( 'reason' ) );
			$add_time = date('Y-m-d H:i:s');

			if (empty ( $user_id ) ||empty ( $chapter_id ) ||empty ( $is_join )) {
				$this->publicverify->jsAlert ( '请完整填写必填字段' );
				exit ();
			}

			$this->load->model ( 'table/study_record_model' );
			$insert_data = array (
					'user_id'=>$user_id,
					'name'=>$name,
					'group_id'=>$group_id,
					'chapter_id'=>$chapter_id,
					'is_join'=>$is_join,
					'is_all_ok'=>$is_all_ok,
					'all_ok_date'=>$all_ok_date,
					'operation_user_id'=>$operation_user_id,
					'is_licence'=>$is_licence,
					'reason'=>$reason,
					'add_time'=>$add_time
			);
			$result = $this->study_record_model->insert ( $insert_data );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '提交成功！', 'admin/study_record/index' );
			} else {
				$this->publicverify->jsAlert ( '提交失败！', 'admin/study_record/add' );
			}
		}
		$data ['view'] = 'application/views/admin/study_record/add';
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
				$name = trim ( $this->input->post ( 'name' ) );
				$group_id = trim ( $this->input->post ( 'group_id' ) );
				$chapter_id = trim ( $this->input->post ( 'chapter_id' ) );
				$is_join = trim ( $this->input->post ( 'is_join' ) );
				$is_all_ok = trim ( $this->input->post ( 'is_all_ok' ) );
				$all_ok_date = trim ( $this->input->post ( 'all_ok_date' ) );
				$operation_user_id = trim ( $this->input->post ( 'operation_user_id' ) );
				$is_licence = trim ( $this->input->post ( 'is_licence' ) );
				$reason = trim ( $this->input->post ( 'reason' ) );
				if (empty ( $user_id ) ||empty ( $chapter_id ) ||empty ( $is_join )) {
					$this->publicverify->jsAlert ( '请完整填写必填字段' );
					exit ();
				}
				$this->load->model ( 'table/study_record_model' );

				$update_data = array (
					'user_id'=>$user_id,
					'name'=>$name,
					'group_id'=>$group_id,
					'chapter_id'=>$chapter_id,
					'is_join'=>$is_join,
					'is_all_ok'=>$is_all_ok,
					'all_ok_date'=>$all_ok_date,
					'operation_user_id'=>$operation_user_id,
					'is_licence'=>$is_licence,
					'reason'=>$reason
				);
				$result = $this->study_record_model->update ( $update_data, array (
						'id' => $id
				) );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '修改成功！', 'admin/study_record/index' );
				} else {
					$this->publicverify->jsAlert ( '修改失败！', 'admin/study_record/add' );
				}
			} else {
				$this->publicverify->jsAlert ( '数据异常！！', 'admin/study_record/index' );
			}
		}
	}

	/*
	 * 删除
	 */
	function del($id) {
		if ($id) {
			$this->load->model ( 'table/study_record_model' );
			$result = $this->study_record_model->delete ( array (
					'id' => $id
			) );
			$this->load->library ( 'publicverify' );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '删除成功！', 'admin/study_record/index' );
			} else {
				$this->publicverify->jsAlert ( '删除失败！', 'admin/study_record/index' );
			}
		}
	}
}