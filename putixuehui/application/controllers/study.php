<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

	/*
 * date:2016-11-14 desc:网站首页 author:Gavin.zhang
 */
class Study extends CI_Controller {
	public $ip = '';
	public $uniquee = '';
	public $is_login = false;
	public $login_user_id = 0;
	public $login_group_id = 0;
	public $login_name = '';
	public function __construct() {
		parent::__construct ();
		// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		$this->init_visit ();
	}


    /**
    * 操作考勤页面
    * @date: 2017年4月28日 下午8:03:13
    * @author: Gavin
    * @param: variable
    * @return:
    */
	public function index() {
	    if ($this->is_login) {
	        $group_model = $this->db->select ( 'name' )->where ( 'id', $this->login_group_id )->get ( 'group' )->first_row ();
	        $data ['group_name'] = $group_model ? $group_model->name : '';

	        $data ['list'] = $this->db->query ( 'select id,name,total_head,wenshu,huaiye from users where group_id=' . $this->login_group_id . ' order by total_head desc limit 100' )->result_array ();
	        $data ['chapter_id'] = 1;
	        $data ['user_id'] = $this->login_user_id;
	        $this->load->view ( 'study', $data );
	    } else {
	        redirect ( 'login' );
	    }
	}


	/**
	 * 更新记录
	 * @date 2016-12-8
	 *
	 * @author Gavin
	 */
	public function save() {
		if ($this->is_login) {
			if ($_POST) {
				$user_id = $this->input->post ( 'user_id' );
				$chapter_id = $this->input->post ( 'chapter_id' );
				$chuanchengs = $this->input->post ( 'chuancheng' );
				$join = $this->input->post ( 'join' );
				$this->load->library ( 'publicverify' );
				if (empty ( $user_id ) || empty ( $chuanchengs ) || empty ( $join )) {
					$this->publicverify->jsAlert ( '提交失败,原因：传承和共修必须选择', 'study/index'  );
					exit ();
				}
				$user_list = $this->db->select('id')->where('group_id',$this->login_group_id)->get('users')->result_array();
				//print_r($user_list);exit;
                if($user_list && count($user_list)>0){
                    foreach ($user_list as $item){
                        $user_id = $item['id'];
                        $is_all_ok = 2;
                        $is_join = 2;
                        if(in_array($user_id, $chuanchengs))
                            $is_all_ok =1;
                        if(in_array($user_id, $join))
                            $is_join =1;
//                         $udpate_sql='update study_record set is_all_ok='.$is_all_ok.',is_join='.$is_join;
//                         if($is_all_ok)
//                             $udpate_sql.=",all_ok_date='".date('Y-m-d')."'";
//                         $udpate_sql.=' where user_id='.$user_id.' and chapter_id='.$chapter_id;
//                         $result= $this->db->query($udpate_sql);
                        $data = array(
                                'user_id'=>$user_id,
                                'group_id'=>$this->login_group_id,
                                'chapter_id'=>$chapter_id,
                                'is_join'=>$is_join,
                                'is_all_ok'=>$is_all_ok,
                                'all_ok_date'=>date('Y-m-d'),
                                'operation_user_id'=>$this->login_user_id,
                                'add_time'=>date("Y-m-d H:i:s")
                        );
                        if($is_all_ok==1)
                            $data['all_ok_date'] = date('Y-m-d');
                        $result += $this->db->insert('study_record',$data);
                    }
                    if($result>0){
                        $this->publicverify->jsAlert ( '操作成功', 'index' );
                        exit ();
                    }else{
                        $this->publicverify->jsAlert ( '提交失败,原因：数据异常', 'study/index' );
                        exit ();
                    }
                }
			} else {
				$this->publicverify->jsAlert ( '操作失败,原因：参数不合法', 'study/index' );
				exit ();
			}
		} else {
			redirect ( 'login' );
		}
	}

	private function get_unsubmit_str($action_list, $group_id) {
		$return_str = '';
		$action_user_array = array ();
		if ($action_list) {
			foreach ( $action_list as $item ) {
				$action_user_array [] = $item ['user_id'];
			}
		}
		$user_list = $this->db->select ( 'id,name' )->where ( 'group_id', $group_id )->get ( 'users' )->result_array ();
		if ($user_list) {
			foreach ( $user_list as $item ) {
				if (! in_array ( $item ['id'], $action_user_array ))
					$return_str .= $item ['name'] . '、';
			}
		}
		return $return_str;
	}




	/**
	 * 初始化访问方法
	 * @date 2016-11-21
	 *
	 * @author Gavin
	 */
	private function init_visit() {
		$unique_json = $this->thor->getUniqueUser ();
		if ($unique_json) {
			$this->uniquee = $unique_json->unique_key;
			$this->is_login = empty ( $unique_json->uid ) ? false : true;
			$this->login_user_id = empty ( $unique_json->uid ) ? 0 : $unique_json->uid;
			$this->login_group_id = empty ( $unique_json->bid ) ? 0 : $unique_json->bid;
			$this->login_name = empty ( $unique_json->name ) ? '' : $unique_json->name;
		}
		$visit_url = $this->thor->get_url ();
		$this->load->library ( 'location' );
		$visit_ip = $this->location->getIp ();
		$this->ip = $visit_ip;
	}
}