<?php
class region extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = "t_region";
	}
	public $page_num = 30;
	
	function getRegion($id){
		$this->db->select(" * ");
		$this->db->where('parent_id',$id);
		$this->db->order_by('sort','desc');
		$query = $this->db->get('t_region');
		$region = $query->result_array();
		$newRegion = array();
		foreach ($region as $key => $value) $newRegion[$value['region_id']] = $value['region_name'];
		$newRegion[''] = '--请选择地区--';
		return $newRegion;
	}
	
	//获取地区名称
	function getNameById($region_id){
		$this->db->select("region_name");
		$this->db->where("region_id",$region_id);
		$query = $this->db->get('t_region')->first_row();
		return $query->region_name;
	}
	
	function getJSONRegion($id){
		$this->db->select(" * ");
		$this->db->where('parent_id',$id);
		$this->db->order_by('sort','desc');
		$query = $this->db->get('t_region');
		$region = $query->result_array();
		$newRegion = array();
		foreach ($region as $key => $value) $newRegion[$value['region_id']] = $value['region_name'];
		return $newRegion;
	}
	
	function getRegionApi($id = 1){
		$this->db->select(" * ");
		$this->db->where('parent_id',$id);
		$this->db->order_by('sort','desc');
		$query = $this->db->get('t_region');
		$region = $query->result_array();
		$newRegion = array();
		foreach ($region as $key => $value) $newRegion[$value['region_id']] = $value['region_name'];
		return $newRegion;
	}
	
	
	function getAreaHTML($data,$array){
		$this->load->model ( 'table/region');
		$area = $this->region->getArea($data);
		$this->load->model ( 'chtml' );
		$array['region'] = $this->chtml->dropDownList('province',$area['province'], $area['provinceArray'],array('class'=>"btn_select address"));
		$array['city'] = $this->chtml->dropDownList('city',$area['city'],$area['cityArray'],array('class'=>"btn_select address"));
		$array['district'] = $this->chtml->dropDownList('district',$area['district'], $area['districtArray'],array('class'=>"btn_select address"));
		return $array;
	}
	
	function getArea( $array ){
		$area['provinceArray'] = $this->getRegion(100000);
		$area['cityArray'] = $area['provinceArray'];
		$area['districtArray'] = $area['provinceArray'];
		$area['province'] = '';
		$area['city'] = '';
		$area['district'] = '';
		if(isset($array['district'])){
			$area['district'] = $array['district'];
		}
		if(isset($array['province'])){
			$area['province'] = $array['province'];
			if($area['province']>0){
				$area['cityArray'] = $this->getRegion($area['province']);
			}
		} else {
			$area['cityArray'] = $area['provinceArray'];
		}
		if(isset($array['city'])){
			$area['city'] = $array['city'];
			if($area['city']>0){
				$area['districtArray'] = $this->getRegion($area['city']);
			}
		} else {
			$area['districtArray'] = $area['provinceArray'];
		}
		return $area;
	}
	
}