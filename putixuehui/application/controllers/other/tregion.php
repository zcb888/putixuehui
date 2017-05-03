<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	/*
 * date:2014-09-11 desc:管理员权限相关 author:Gavin.zhang
 */
class tregion extends CI_Controller {
	public function __construct() {
		parent::__construct ();
	}
	
	//获取企业列表
	function ajaxGetRegionList($id){
		$newRegion = array();
		$this->load->model ( 'table/region');
		$region = $this->region->getJSONRegion($id);
		// print_r($newRegion);
		$newRegion = json_encode($region);

		header('Content-type:text/json');
		echo $newRegion;
	}
}