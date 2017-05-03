<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	/*
 * date:2014-09-11 desc:管理员权限相关 author:Gavin.zhang
 */
class Groups extends CI_Controller {
	private $checked;
	private $data;
	public function __construct() {
		parent::__construct ();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
	}

	// 添加管理员组
	public function create() {
		if (isset ( $_POST ['save'] )) {
			if ($this->rules ()) {
				$name = $this->input->post ( 'name' );
				$description = $this->input->post ( 'description' );
				if ($name && $name!='请输入名称') {
					$sql = "insert into static_permission_group (name, description)
                    values (" . $this->db->escape ( $name ) . ", " . $this->db->escape ( $description ) . ")";
					if ($this->db->query ( $sql )) {
						echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
						echo "<script type='text/javascript'>alert('添加成功!');window.location.href ='" . site_url ( 'admin/groups/lists' ) . "';</script>";
						exit ();
					}
				}
			}
		}
		$data ['view'] = 'application/views/admin/group/create';
		$this->load->view ( 'admin/common/frame', $data );
	}
	private function rules() {
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', '组名', 'trim|required|min_length[1]|max_length[30]' );
		if ($this->form_validation->run () == FALSE) {
			return false;
		} else {
			return true;
		}
	}
	private function editRules() {
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', '组名', 'trim|required|min_length[1]|max_length[30]' );
		if ($this->form_validation->run () == FALSE) {
			return false;
		} else {
			return true;
		}
	}
	// 管理员组列表
	public function lists() {
		//$this->permission->webHasAccess ( 'groups_lists' );
		// $this->permission->hasAccess('SET_ADMINGROUP');
		$sql = "select id, name, description from static_permission_group ";
		$query = $this->db->query ( $sql );
		$this->eData ['lists'] = $query->result_array ();
		$this->eData ['view'] = 'application/views/admin/group/lists';
		$this->load->view ( 'admin/common/frame', $this->eData );
	}

	// 编辑管理员组
	public function edit($group_id = '') {
		if (isset ( $_POST ['save'] )) {
			if ($this->editRules ()) {
				$id = $this->input->post ( 'id' );
				$name = $this->input->post ( 'name' );
				$description = $this->input->post ( 'description' );
				$update = "update static_permission_group
                        set name = '{$name}', description = '{$description}'
                        where id = {$id}";
				if ($this->db->query ( $update )) {
					echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
					echo "<script type='text/javascript'>alert('编辑成功!');window.location.href ='" . site_url ( 'admin/groups/lists' ) . "';</script>";
					exit ();
				}
			} else {
				$group_id = $this->input->post ( 'id' );
			}
		}
		if (empty ( $group_id )) {
			redirect ( 'groups/lists' );
		}
		$sql = "select id, name, description from static_permission_group where id = $group_id";
		$query = $this->db->query ( $sql );
		if ($query->num_rows == 0) {
			redirect ( 'admin/groups/lists' );
		}
		$result = $query->result_array ();
		$data ['item'] = $result [0];
		$data ['view'] = 'application/views/admin/group/edit';
		$this->load->view ( 'admin/common/frame', $data );
	}
	public function authority($group_id) {
		// $this->load->model ( 'table/static_admin', '', TRUE );
		$this->eData ['list'] = $this->static_admin->authority ( $group_id );
		$this->eData ['view'] = 'system/group/module';
		$this->eData ['gid'] = $group_id;
		$this->eData ['view'] = 'application/views/admin/group/authority';
		$this->load->view ( 'admin/common/frame', $this->eData );
	}
	public function getAuthority($id) {
		$sql = "select modules from static_permission_group where id = $id";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		if (count ( $result ) > 0)
			return unserialize ( $result [0] ['modules'] );
		else
			return false;
	}
	public function postAuthority() {
		if ($_POST) {
			$group_id = $this->input->post ( 'gid' );
			$modules = serialize ( $this->input->post ( 'item' ) );
			$sql = 'update static_permission_group
                set modules = ' . $this->db->escape ( $modules ) . '
                where id = ' . $group_id;
			if ($this->db->query ( $sql )) {
				// $this->olog->write('用户组管理','更新了用户组id为' . $group_id . '的权限');
				redirect ( 'admin/groups/lists' );
			} else
				redirect ( 'admin/groups/authority/' . $group_id );
		}
	}
	private function getFormatModule() {
		$sql = "select id, pid, name from static_permission_module";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$array = array ();
		foreach ( $result as $item ) {
			$array [$item ['pid']] [$item ['id']] = $item ['name'];
		}
		echo '<ul>';
		foreach ( $array [0] as $key => $item ) {
			echo "<li><input type='checkbox' name='item[]' value='$key' " . $this->checkbox ( $key ) . " />{$item}";
			if (isset ( $array [$key] )) {
				$this->tree ( $array [$key], $array );
			}
			echo '</li>';
		}
		echo '</ul>';
	}
	private function checkbox($key) {
		if ($this->checked) {
			if (in_array ( $key, $this->data )) {
				return "checked = 'checked'";
			}
		}
	}
	private function tree($items, $array) {
		echo '<ul>';
		foreach ( $items as $key => $item ) {
			echo "<li><input type='checkbox' name='item[]' value='$key'" . $this->checkbox ( $key ) . " />{$item}";
			if (! empty ( $array [$key] ))
				$this->tree ( $array [$key], $array );
		}
		echo '</li>';
		echo '</ul>';
	}
	private function getHeader() {
		return '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
            <head>
                <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
                <title>后台管理</title>
                <link rel="stylesheet" type="text/css" href="' . base_url () . 'style/css/reset.css" />
                <link rel="stylesheet" type="text/css" href="' . base_url () . 'style/css/admin.css" />
				<script type="text/javascript" src="' . base_url () . 'style/js/jQuery v1.10.0.js"></script>
				<script type="text/javascript" src="' . base_url () . 'style/js/methodjs.js"></script>
				<script type="text/javascript" src="' . base_url () . 'style/js/myjs.js"></script>
            </head>
            <body>';
	}

	// 列表
	public function adminlist() {
		$this->permission->hasAccess ( 'groups_adminlist' );
		$pageindex = $this->input->get ( 'per_page' );
		$pageindex = empty ( $pageindex ) ? 1 : $pageindex;
		$name = addslashes ( $this->input->get ( 'name' ) );
		$username = addslashes ( $this->input->get ( 'username' ) );
		$data = array ();
		$url = "/admin/groups/adminlist?username=" . $username . "&name=" . $name;

		$where_condition = " where 1=1";
		if (!empty($name) )
			$where_condition .= " and static_admin.name like'%$name%'";
		if (!empty($username))
			$where_condition .= " and username ='$username'";

		$count = $this->GetTotalCount ( $where_condition );
		$data ['name'] = $name;
		$data ['username'] = $username;
		$this->load->library ( 'pagination' );
		$config = $this->fun->page ( $url, $count, 15, $url, 4 );
		$config ['page_query_string'] = TRUE;
		$this->pagination->initialize ( $config );

		$data ['pagination'] = $this->pagination->create_links ();

		$select_sql = "select static_admin.id,static_admin.username , static_admin.name,
			 static_admin.addtime regtime, pg.name groups from static_admin
			 inner join static_permission_group pg
			 on static_admin.permission = pg.id" . $where_condition;
		// $select_sql = "select * from user_message $where_condition order by id desc";
		$limit_count = ($pageindex - 1) * $config ['per_page'];
		$page_size = $config ['per_page'];
		$select_sql .= " limit $limit_count,$page_size ";
		$query = $this->db->query ( $select_sql );
		$list = $query->result_array ();
		$data ['list'] = $list;
		$data ['view'] = 'application/views/admin/group/adminlist';
		$this->load->view ( 'admin/common/frame', $data );
	}

	// 获取总数
	private function GetTotalCount($condition) {
		$sql = "select count(0) c from static_admin
                 inner join static_permission_group pg
                 on static_admin.permission = pg.id " . $condition;
		$query = $this->db->query ( $sql );
		$first_row = $query->first_row ();
		return $first_row->c;
	}

	// 添加管理员
	public function adminadd() {
		$this->permission->hasAccess ( 'groups_adminadd' );
		$this->load->library ( 'publicverify' );
		if (! empty ( $_POST )) {
			if (isset ( $_POST ['save'] )) {
				$admin_username = $this->input->post ( 'admin_username' );
				$name = $this->input->post ( 'name' );
				$email = $this->input->post ( 'email' );
				$password = $this->input->post ( 'admin_password' );
				$manger_group_id = $this->input->post ( 'manger_group_id' );
				if (empty ( $admin_username)) {
					$this->publicverify->jsAlert ( '请输入帐号','admin/groups/adminadd');
					exit ();
				}
				if (empty ( $name)) {
					$this->publicverify->jsAlert ( '请输入姓名','admin/groups/adminadd');
					exit ();
				}
				if (empty ( $password)) {
					$this->publicverify->jsAlert ( '请输入密码','admin/groups/adminadd');
					exit ();
				}
				$email_is_ok = $this->publicverify->checkEmail($email);
				if(!$email_is_ok){
					$this->publicverify->jsAlert ( '邮箱格式不正确','admin/groups/adminadd');
					exit ();
				}
				$this->db->select ( 'id' );
				$this->db->where ( "username", $this->input->post ( 'admin_username' ) );
				$info = $this->db->get ( 'static_admin' )->result_array ();
				if (! empty ( $info )) {
					$this->publicverify->jsAlert ( '账户已经存在,请重新填写！','admin/groups/adminadd');
					exit ();
				}
				$salt = $this->thor->getSaltStr ();
				if (empty ( $password )) {
					$pass = md5 ( md5 ( 123456 ) . $salt );
				} else {
					$pass = md5 ( md5 ( $password ) . $salt );
				}

				$data = array (
						'username' => $this->input->post ( 'admin_username' ),
						'password' => $pass,
						'email'=>$email,
						'permission' => $this->input->post ( 'permissions' ),
						'name' => $name,
						'manger_group_id' => $manger_group_id,
						'addtime' => date ( "Y-m-d H:i:s", time () )
				);
				$result = $this->db->insert ( "static_admin", $data );

				$message = $result ? '添加成功!' : '添加失败！';
				echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
				echo "<script type='text/javascript'>alert('" . $message . "');window.location.href ='" . site_url ( 'admin/groups/adminlist' ) . "';</script>";
			} else {
				echo "<script type='text/javascript'>window.location.href ='" . site_url ( 'admin/groups/adminlist' ) . ";</script>";
			}
		}

		$this->eData ['group_list'] = $this->db->select('id,name,leader')->get('group')->result_array();
		$this->eData ['perlist'] = $this->getGroups ();
		$this->eData ['view'] = 'application/views/admin/group/adminadd';
		$this->load->view ( 'admin/common/frame', $this->eData );
	}

	// 管理员编辑
	public function adminedit($id) {
		if (! empty ( $_POST )) {
			if (isset ( $_POST ['save'] )) {
				if (empty ( $_POST ['admin_username'] )) {
					echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
					echo '<script type="text/javascript">alert("请填入用户名!"); </script>';
				} else {
					$password = $this->input->post ( 'admin_password' );
					$data = array (
							'username' => $this->input->post ( 'admin_username' ),
							'email'=>$this->input->post ( 'email' ),
							'permission' => $this->input->post ( 'permissions' ),
							'manger_group_id' => $this->input->post ( 'manger_group_id' ),
							'name' => $this->input->post ( 'name' )
					);
					if (! empty ( $password )) {
						$salt = $this->thor->getSaltStr ();
						$data ['password'] = md5 ( md5 ( $password ) . $salt );
					}
					// if(!empty($data['cash']))$data['cash']=1;
					$this->db->where ( "id", $id );
					$result = $this->db->update ( "static_admin", $data );

					$this->load->library ( 'publicverify' );
					if ($result > 0) {
						$this->publicverify->jsAlert ( '编辑成功!', 'admin/groups/adminlist' );
						exit ();
					}
				}
			} else {
				echo "<script type='text/javascript'>window.location.href ='" . site_url ( 'admin/groups/adminlist' ) . "';</script>";
			}
		}
		$this->db->select ( '*' );
		$this->db->where ( 'id', $id );
		$user = $this->db->get ( "static_admin" )->result_array ();
		$this->eData ['user'] = $user [0];
		$this->eData ['perlist'] = $this->getGroups ();
		$this->eData ['group_list'] = $this->db->select('id,name,leader')->get('group')->result_array();

		$this->eData ['view'] = 'application/views/admin/group/adminedit';
		$this->load->view ( 'admin/common/frame', $this->eData );
	}
	public function getGroups() {
		$sql = "select id, name from static_permission_group";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}

	// 修改密码
	public function changepwd() {
		$this->permission->hasAccess ( 'groups_changepwd' );
		$username = $this->session->userdata ( 'loginname' );
		if (isset ( $_POST ['save'] )) {
			$old_password = $this->input->post ( 'old_password' );
			$salt = $this->thor->getSaltStr ();
			$md5_old_password = md5 ( md5 ( $old_password ) . $salt );

			$password = $this->input->post ( 'admin_password' );

			if ($old_password && $password) {
				$this->load->library ( 'publicverify' );
				$this->db->where ( "username", $username );
				$eRow = $this->db->get ( 'static_admin' )->first_row ();
				if ($eRow->password == $md5_old_password) {
					$this->db->where ( "password", $md5_old_password );
					$this->db->where ( "username", $username );
					$array_data ['password'] = md5 ( md5 ( $password ) . $salt );
					$issuccess = $this->db->update ( "static_admin", $array_data );

					if ($issuccess) {
						$this->publicverify->jsAlert ( '密码修改成功', 'admin/groups/changepwd' );
						exit ();
					} else {
						$this->publicverify->jsAlert ( '密码修改失败', 'admin/groups/changepwd' );
						exit ();
					}
				} else {
					$this->publicverify->jsAlert ( '原始密码输入错误', 'admin/groups/changepwd' );
					exit ();
				}
			}
		}
		$data ['username'] = $username;
		$data ['view'] = 'application/views/admin/group/changepwd';
		$this->load->view ( 'admin/common/frame', $data );
	}

	/**
	 * 删除管理员
	 */
	public function deladmin() {
		$id = $this->input->get ( 'id' );
		if ($id) {
			$this->db->where ( 'id', $id );
			$this->db->delete ( 'static_admin' );
			$model = $this->db->get ( 'static_admin' )->first_row ();
		}
		redirect ( 'admin/groups/adminlist' );
	}
}