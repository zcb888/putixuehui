<?php
class Study_record_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = "study_record";
	}
}