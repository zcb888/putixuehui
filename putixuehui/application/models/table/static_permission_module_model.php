<?php
class Static_permission_module_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = "static_permission_module";
	}
}