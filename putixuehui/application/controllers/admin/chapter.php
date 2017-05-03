<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Chapter extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}

	/*
	 * 首页列表
	 */
	public function index() {
		//$this->permission->webHasAccess ( 'chapter_index' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;

		$url = "/admin/chapter/index";

		$this->load->model ( 'table/chapter_model' );

		$where_condition = array (
		);
		$like_condition = array (
		);
		$sort = array (
				'id' => 'desc'
		);
		$list = $this->chapter_model->getListByCondition ( $where_condition, $like_condition, $pageindex, $sort,'*',20 );
		$count = $this->chapter_model->getCountByArray ( $where_condition, $like_condition );

		$data = array ();
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 20, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );
		$data ['pagination'] = $this->pagination->create_links ();
		$data ['list'] = $list;

		$data ['view'] = 'application/views/admin/chapter/index';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/*
	 * 编辑
	 */
	function edit($id) {
		if ($id) {
			$this->load->model ( 'table/chapter_model' );
			$model = $this->chapter_model->getModelByPrimaryKey ( array (
					'id' => $id
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/chapter/edit';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}


/*
 * 展示
*/
	function detail($id) {
		if ($id) {
			$this->load->model ( 'table/chapter_model' );
			$model = $this->chapter_model->getModelByPrimaryKey ( array (
					'id' => $id
			) );
			$data ['model'] = $model;
			$data ['view'] = 'application/views/admin/chapter/detail';
			$this->load->view ( 'admin/common/frame', $data );
		}
	}

	/*
	 * 添加
	 */
	public function add() {
		// $this->permission->webHasAccess ( 'chapter_add' );
		if (! empty ( $_POST )) {
			$this->load->library ( 'publicverify' );
			$grade_id = trim ( $this->input->post ( 'grade_id' ) );
			$start_date = trim ( $this->input->post ( 'start_date' ) );
			$end_date = trim ( $this->input->post ( 'end_date' ) );
			$book = trim ( $this->input->post ( 'book' ) );
			$chapter = trim ( $this->input->post ( 'chapter' ) );
			$sort = trim ( $this->input->post ( 'sort' ) );
			$add_time = date('Y-m-d H:i:s');

			if (empty ( $grade_id ) ||empty ( $start_date ) ||empty ( $end_date ) ||empty ( $chapter )) {
				$this->publicverify->jsAlert ( '请完整填写必填字段' );
				exit ();
			}
			$this->load->model ( 'table/chapter_model' );
			$insert_data = array (
					'grade_id'=>$grade_id,
					'start_date'=>$start_date,
					'end_date'=>$end_date,
					'book'=>$book,
					'chapter'=>$chapter,
					'sort'=>$sort,
					'add_time'=>$add_time
			);
			$result = $this->chapter_model->insert ( $insert_data );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '提交成功！', 'admin/chapter/index' );
			} else {
				$this->publicverify->jsAlert ( '提交失败！', 'admin/chapter/add' );
			}
		}
		$data ['view'] = 'application/views/admin/chapter/add';
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
				$grade_id = trim ( $this->input->post ( 'grade_id' ) );
				$start_date = trim ( $this->input->post ( 'start_date' ) );
				$end_date = trim ( $this->input->post ( 'end_date' ) );
				$book = trim ( $this->input->post ( 'book' ) );
				$chapter = trim ( $this->input->post ( 'chapter' ) );
				$sort = trim ( $this->input->post ( 'sort' ) );
				if (empty ( $grade_id ) ||empty ( $start_date ) ||empty ( $end_date ) ||empty ( $chapter )) {
					$this->publicverify->jsAlert ( '请完整填写必填字段' );
					exit ();
				}
				$this->load->model ( 'table/chapter_model' );

				$update_data = array (
					'grade_id'=>$grade_id,
					'start_date'=>$start_date,
					'end_date'=>$end_date,
					'book'=>$book,
					'chapter'=>$chapter,
					'sort'=>$sort
				);
				$result = $this->chapter_model->update ( $update_data, array (
						'id' => $id
				) );
				if ($result > 0) {
					$this->publicverify->jsAlert ( '修改成功！', 'admin/chapter/index' );
				} else {
					$this->publicverify->jsAlert ( '修改失败！', 'admin/chapter/add' );
				}
			} else {
				$this->publicverify->jsAlert ( '数据异常！！', 'admin/chapter/index' );
			}
		}
	}

	/*
	 * 删除
	 */
	function del($id) {
		if ($id) {
			$this->load->model ( 'table/chapter_model' );
			$result = $this->chapter_model->delete ( array (
					'id' => $id
			) );
			$this->load->library ( 'publicverify' );
			if ($result > 0) {
				$this->publicverify->jsAlert ( '删除成功！', 'admin/chapter/index' );
			} else {
				$this->publicverify->jsAlert ( '删除失败！', 'admin/chapter/index' );
			}
		}
	}
}