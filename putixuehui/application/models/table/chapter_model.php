<?php
class Chapter_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = "chapter";
	}
}