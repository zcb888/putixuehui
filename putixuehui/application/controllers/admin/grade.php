<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Grade extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}

	/*
	 * 首页列表
	 */
	public function index() {
		//$this->permission->webHasAccess ( 'grade_index' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$course_type = trim ( $this->input->get ( 'course_type' ) );
		$year = trim ( $this->input->get ( 'year' ) );
		$url = "/admin/grade/index?course_type=".$course_type."&year=".$year;

		$this->load->model ( 'table/grade_model' );

		$where_condition = array (
				'course_type'=>$course_type,
				'year'=>$year
		);
		$like_condition = array (
		);
		$sort = array (
				'id' => 'desc'
		);
		$list = $this->grade_model->getListByCondition ( $where_condition, $like_condition, $pageindex, $sort,'*',20 );
		$count = $this->grade_model->getCountByArray ( $where_condition, $like_condition );

		$data = array ('course_type'=>$course_type,'year'=>$year);
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 20, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;

		$data ['view'] = 'application/views/admin/grade/index';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/*
	 * 编辑
	 */
	function edit($id) {
		if ($id) {
			$this->load->model ( 'table/grade_model' );
			$model = $this->grade_model->getModelByPrimaryKey ( array (
					'id' => $id
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/grade/edit';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}


/*
 * 展示
*/
	function detail($id) {
		if ($id) {
			$this->load->model ( 'table/grade_model' );
			$model = $this->grade_model->getModelByPrimaryKey ( array (
					'id' => $id
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/grade/detail';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}

	/*
	 * 添加
	 */
	public function add() {
		// $this->permission->webHasAccess ( 'grade_add' );
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			$course_type = trim ( $this->input->post ( 'course_type' ) );
			$year = trim ( $this->input->post ( 'year' ) );
			$introduction = trim ( $this->input->post ( 'introduction' ) );
			$remark = trim ( $this->input->post ( 'remark' ) );
			$add_time = date('Y-m-d H:i:s');

			if (empty ( $course_type ) ||empty ( $year )) {
				$this->publicverify->jsAlert ( '请完整填写必填字段' );
				exit ();
			}
			$this->load->model ( 'table/grade_model' );
			$insert_data = array (
					'course_type'=>$course_type,
					'year'=>$year,
					'introduction'=>$introduction,
					'remark'=>$remark,
					'add_time'=>$add_time
			);
			$result = $this->grade_model->insert ( $insert_data );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '提交成功！', 'admin/grade/index' );
			} else {
				$this->publicverify->jsAlert ( '提交失败！', 'admin/grade/add' );
			}
		}
		$data ['view'] = 'application/views/admin/grade/add';
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
				$course_type = trim ( $this->input->post ( 'course_type' ) );
				$year = trim ( $this->input->post ( 'year' ) );
				$introduction = trim ( $this->input->post ( 'introduction' ) );
				$remark = trim ( $this->input->post ( 'remark' ) );
				if (empty ( $course_type ) ||empty ( $year )) {
					$this->publicverify->jsAlert ( '请完整填写必填字段' );
					exit ();
				}
				$this->load->model ( 'table/grade_model' );

				$update_data = array (
					'course_type'=>$course_type,
					'year'=>$year,
					'introduction'=>$introduction,
					'remark'=>$remark
				);
				$result = $this->grade_model->update ( $update_data, array (
						'id' => $id
				) );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '修改成功！', 'admin/grade/index' );
				} else {
					$this->publicverify->jsAlert ( '修改失败！', 'admin/grade/add' );
				}
			} else {
				$this->publicverify->jsAlert ( '数据异常！！', 'admin/grade/index' );
			}
		}
	}

	/*
	 * 删除
	 */
	function del($id) {
		if ($id) {
			$this->load->model ( 'table/grade_model' );
			$result = $this->grade_model->delete ( array (
					'id' => $id
			) );
			$this->load->library ( 'publicverify' );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '删除成功！', 'admin/grade/index' );
			} else {
				$this->publicverify->jsAlert ( '删除失败！', 'admin/grade/index' );
			}
		}
	}
}