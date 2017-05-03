<?php
class Group_stduy_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = "group_stduy";
	}


	/**
	 * 查询
	 * @date 2016-10-20
	 *
	 * @author Gavin
	 */
	function search($name,$group_id, $startdate, $enddate, $page) {
	    $sql = 'select a.*,b.name from group_stduy a left join `group` b on a.group_id=b.id where 1=1 ';
	    if (!empty($name))
	        $sql .= " and b.name like '%" . $name."%'";
	    if($group_id)
	        $sql .= " and b.id=".$group_id;
	    if ($startdate) {
	        $sql .= " and a.join_date>='" . $startdate . "'";
	    }
	    if ($enddate) {
	        $sql .= " and a.join_date<='" . $enddate . "'";
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
	    $sql = 'select count(0) c from group_stduy a left join `group` b on a.group_id=b.id where 1=1 ';
	    if (!empty($name))
	        $sql .= " and b.name like'%" . $name."%'";
	    if($group_id)
	        $sql .= " and b.id=".$group_id;
	    if ($startdate) {
	        $sql .= " and a.join_date>='" . $startdate . "'";
	    }
	    if ($enddate) {
	        $sql .= " and a.join_date<='" . $enddate . "'";
	    }
	    return $this->getFirstValue ( $sql );
	}

}