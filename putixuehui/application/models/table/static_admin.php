<?php
class static_admin extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = "static_admin";
	}
	private $html = '';
	private $first = '';
	private $i = 0;
	private $url = array ();
	private $modules = array ();
	private $data = array ();
	function menuData() {
		$group_id = $this->session->userdata ( 'group' );
		$this->db->select ( "modules" );
		$this->db->where ( "id", $group_id );
		$obj = $this->db->get ( "static_permission_group" )->first_row ();

		$this->modules = empty($obj->modules) ? null:unserialize ( $obj->modules );
		if (! $this->modules) {
			$this->modules = array ();
		}
		$this->db->select ( "id,pid,name,url" );
		$this->db->order_by ( "id", "asc" );
		$result = $this->db->get ( "static_permission_module" )->result_array ();
		$array = array ();
		foreach ( $result as $item ) {
			$array [$item ['pid']] [$item ['id']] = $item ['name'];
			$this->url [$item ['id']] = $item ['url'];
		}
		$index = 0;
		foreach ( $array [0] as $key => $value ) {
			if (! in_array ( $key, $this->modules ))
				continue;
			$this->html .= "<li><h3 class=\"user_up\"><i class=\"icon3_w\"></i>" . $value . "</h3>"; // h3 class=\"user_up\"
			if (isset ( $array [$key] )) {
				$this->makeMenu ( $array [$key], $array, 1, $key );
			}
			$this->html .= '</li>';
		}
		return $this->html;
	}
	function get_url() {
		$sys_protocal = isset ( $_SERVER ['SERVER_PORT'] ) && $_SERVER ['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER ['PHP_SELF'] ? $_SERVER ['PHP_SELF'] : $_SERVER ['SCRIPT_NAME'];
		$path_info = isset ( $_SERVER ['PATH_INFO'] ) ? $_SERVER ['PATH_INFO'] : '';
		$relate_url = isset ( $_SERVER ['REQUEST_URI'] ) ? $_SERVER ['REQUEST_URI'] : $php_self . (isset ( $_SERVER ['QUERY_STRING'] ) ? '?' . $_SERVER ['QUERY_STRING'] : $path_info);
		return $sys_protocal . (isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : '') . $relate_url;
	}
	function makeMenu($items, $array, $level, $num = '') {
		$this->html .= '<ul>';
		$index = 0;
		foreach ( $items as $key => $item ) {
			if (! in_array ( $key, $this->modules ))
				continue;
			$index ++;
			$full_url = $this->get_url ();
			if (strpos ( $full_url, $this->url [$key] ) > 0) { // $index==1 && $parent_index ==1
				$this->html .= "<li class=\"a_up\"><a href='" . site_url ( $this->url [$key] ) . "'";
			} else {
				$this->html .= "<li><a href='" . site_url ( $this->url [$key] ) . "'";
			}
			if ($this->i == 0)
				$this->html .= " ";
			$this->html .= ">{$item}</a></li>";
			
			if ($this->i == 0) {
				$this->first = $this->url [$key];
				$this->i = 1;
			}
		}
		$this->html .= '</ul>';
	}
	function first() {
		return $this->first;
	}
	
	public function authority($group_id){
		$re_result = null;
		$all_result = $this->get_module(0);
		$select_array = $this->getAuthority($group_id);
		if($all_result && count($all_result)>0){
			foreach ($all_result as $item){
				if($select_array && in_array($item['id'], $select_array)){
					$item['selected'] =true;
				}
				$item_result = $this->get_module($item['id']);
				if($item_result && count($item_result)>0){
					foreach ($item_result as $key=>$subitem){
						if($select_array && in_array($subitem['id'], $select_array)){
							$item_result[$key]['selected'] =true;
						}
					}
				}
				$item['list'] = $item_result;
				$re_result[] = $item;
			}
		}else{
			$re_result = $select_array;
		}
		return $re_result;
	}
	
	function get_module($pid){
		$sql = 'select id, pid, name from static_permission_module where pid='.$pid;
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
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

	private function tree($items, $array) {
		foreach ( $items as $key => $item ) {
			$items [$key] = array ();
			$items [$key] [$key] = $item;
		}
		return $items;
	}
	function getList() {
		$sql = "select id,name from static_admin order by id desc";
		$query = $this->db->query ( $sql )->result_array ();
		return $query;
	}
}