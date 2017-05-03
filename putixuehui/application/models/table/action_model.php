<?php
class Action_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = "action";
	}
	
	
	/**
	 * 查询
	 * @date 2016-10-20
	 *
	 * @author Gavin
	 */
	function search($name,$group_id, $startdate, $enddate, $page) {
		$sql = 'select a.*,b.name from action a left join users b on a.user_id=b.id where 1=1 ';
		if (!empty($name))
			$sql .= " and b.name='" . $name."'";
		if($group_id)
			$sql .= " and b.group_id=".$group_id;
		if ($startdate) {
			$sql .= " and a.action_date>='" . $startdate . "'";
		}
		if ($enddate) {
			$sql .= " and a.action_date<='" . $enddate . "'";
		}
		$sql .=" order by a.id desc ";
		if ($page > 0) {
			$page_count = $this->page_num;
			$limit = ($page - 1) * $this->page_num;
			$sql .= " limit $limit,$page_count";
		}
		return $this->db->query ( $sql )->result_array ();
	}
	
	/**
	 * 查询
	 * @date 2016-10-20
	 *
	 * @author Gavin
	 */
	function search_count($name,$group_id, $startdate, $enddate) {
		$sql = 'select count(0) c from action a left join users b on a.user_id=b.id where 1=1 ';
		if (!empty($name))
			$sql .= " and b.name='" . $name."'";
		if($group_id)
			$sql .= " and b.group_id=".$group_id;
		if ($startdate) {
			$sql .= " and a.action_date>='" . $startdate . "'";
		}
		if ($enddate) {
			$sql .= " and a.action_date<='" . $enddate . "'";
		}
		return $this->getFirstValue ( $sql );
	}
	
	
	/**
	 * 查询
	 * @date 2016-10-20
	 *
	 * @author Gavin
	 */
	function search_detail($user_id, $startdate, $enddate, $page) {
		$sql = 'select a.*,b.name from action a left join users b on a.user_id=b.id where 1=1 ';
		if (!empty($user_id))
			$sql .= " and a.user_id=".$user_id;
		if ($startdate) {
			$sql .= " and a.action_date>='" . $startdate . "'";
		}
		if ($enddate) {
			$sql .= " and a.action_date<='" . $enddate . "'";
		}
		$sql .=" order by a.id desc ";
		if ($page > 0) {
			$page_count = $this->page_num;
			$limit = ($page - 1) * $this->page_num;
			$sql .= " limit $limit,$page_count";
		}
		return $this->db->query ( $sql )->result_array ();
	}
	
	/**
	 * 查询
	 * @date 2016-10-20
	 *
	 * @author Gavin
	 */
	function search_detail_count($user_id, $startdate, $enddate) {
		$sql = 'select count(0) c from action a left join users b on a.user_id=b.id where 1=1 ';
		if (!empty($user_id))
			$sql .= " and a.user_id=".$user_id;
		if ($startdate) {
			$sql .= " and a.action_date>='" . $startdate . "'";
		}
		if ($enddate) {
			$sql .= " and a.action_date<='" . $enddate . "'";
		}
		return $this->getFirstValue ( $sql );
	}

	/**
	 * 查询
	 * @date 2017-04-04
	 *	统计报表
	 * @author Gavin
	 */
	function search_week($group_id, $startdate, $enddate) {
		$sql = 'select a.user_id,b.name,sum(a.total_head) as week_total,b.total_head,sum(a.guanxiu) as guanxiu_total from action a left join users b on a.user_id=b.id where 1=1 ';
		if($group_id)
			$sql .= " and b.group_id=".$group_id;
		if ($startdate) {
			$sql .= " and a.action_date>='" . $startdate . "'";
		}
		if ($enddate) {
			$sql .= " and a.action_date<='" . $enddate . "'";
		}
		$sql .=" group by a.user_id  order by week_total desc";
		return $this->db->query ( $sql )->result_array ();
	}
}