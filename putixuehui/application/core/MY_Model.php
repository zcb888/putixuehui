<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * Copyright (c) 2015, 苏州福临网络科技有限公司
 * All rights reserved.
 *
 * 日		期：2015-09-07
 * 文件名称：MY_Model.php
 * 摘		要：数据库查询基类
 * 作		者：Gavin
 */
class MY_Model extends CI_Model {
	public $page_num = 20;
	public $table_name = '';
	function __construct() {
		parent::__construct ();
	}
	
	/*
	 * 根据数组查询list $and_array：and查询条件数组 $like_array：like查询条件数组 $table_name：表名 $page：当前页 :page=0,不分页
	 */
	function getListByCondition($and_array = array(), $like_array = array(), $page = 1, $sort_array = array(), $field = '*',$page_szie = 10 ) {
		$this->db->select ( $field );
		if (count ( $and_array ) > 0) {
			foreach ( $and_array as $key => $value ) {
				if (! empty ( $value )) {
					$this->db->where ( $key, $value );
				}
			}
		}
		if (count ( $like_array ) > 0) {
			foreach ( $like_array as $key => $value ) {
				if (! empty ( $value )) {
					$this->db->like ( $key, $value );
				}
			}
		}
		if (count ( $sort_array ) > 0) {
			foreach ( $sort_array as $key => $value ) {
				$this->db->order_by ( $key, $value );
			}
		}
		if($page_szie!=10)
			$this->page_num = $page_szie;
		if ($page > 0) {
			$this->db->limit ( $this->page_num, ($page - 1) * $this->page_num );
		}
		$query = $this->db->get ( $this->table_name );
		$list = $query->result_array ();
		return $list;
	}
	
	/*
	 * 根据主键查询一条数据 $and_array：and查询条件数组 $table_name：表名
	 */
	function getModelByPrimaryKey($and_array, $field = '*') {
		$this->db->select ( $field );
		if (count ( $and_array ) > 0) {
			foreach ( $and_array as $key => $value ) {
				$this->db->where ( $key, $value );
			}
		}
		$query = $this->db->get ( $this->table_name );
		$list = $query->first_row ();
		return $list;
	}
	
	/*
	 * 根据数组查询count $and_array：and查询条件数组 $like_array：like查询条件数组 $table_name：表名
	 */
	function getCountByArray($and_array = array(), $like_array = array()) {
		$this->db->select ( 'count(0) as count' );
		if (count ( $and_array ) > 0) {
			foreach ( $and_array as $key => $value ) {
				if (! empty ( $value )) {
					$this->db->where ( $key, $value );
				}
			}
		}
		if (count ( $like_array ) > 0) {
			foreach ( $like_array as $key => $value ) {
				if (! empty ( $value )) {
					$this->db->like ( $key, $value );
				}
			}
		}
		$query = $this->db->get ( $this->table_name );
		$first_row = $query->first_row ();
		return $first_row->count;
	}
	
	/*
	 * 根据sql查询list $sql：sql语句 $page：当前页:pageIndex=0,不分页
	 */
	function getListBySql($sql = "", $page = 1,$page_szie = 10) {
		if($page_szie!=10)
			$this->page_num = $page_szie;
		if ($page > 0) {
			$sql .= " limit " . ($page - 1) * $this->page_num . " , " . $this->page_num;
		}
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	
	/*
	 * 更新
	 */
	function update($updateArray = array(), $whereArray = array()) {
		$result = 0;
		if (! empty ( $updateArray ) && ! empty ( $whereArray )) {
			foreach ( $whereArray as $key => $value ) {
				$this->db->where ( $key, $value );
			}
		}
		$result = $this->db->update ( $this->table_name, $updateArray );
		return $result;
	}
	
	/*
	 * 删除
	 */
	function delete($whereArray = array()) {
		$result = 0;
		if (! empty ( $updateArray ) && ! empty ( $whereArray )) {
			foreach ( $whereArray as $key => $value ) {
				$this->db->where ( $key, $value );
			}
		}
		return $this->db->delete ( $this->table_name, $whereArray );
	}
	
	/*
	 * 添加
	 */
	function insert($insertArray = array()) {
		$result = 0;
		if (! empty ( $insertArray )) {
			$result = $this->db->insert ( $this->table_name, $insertArray );
		}
		return $result;
	}
	
	/*
	 * 获取第一行第一列
	 */
	function getFirstValue($sql) {
		$value = 0;
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		if ($result) {
			$value = current ( $result [0] ); // current($result[0]);
		}
		return $value;
	}
}
?>