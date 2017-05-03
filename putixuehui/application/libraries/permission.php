<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permission
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function hasLogin()
    {
        $islogin = $this->CI->session->userdata('logged_in');
        $this->goLogin($islogin);
    }

    public function hasAccess($module)
    {
        $group_id = $this->CI->session->userdata('group');
        $this->goLogin($group_id);
        $sql = 'select modules from static_permission_group where id = ' . $group_id;
        $query = $this->CI->db->query($sql);
        $result = $query->result_array();
        $modules = unserialize($result[0]['modules']);

        $msql = "select id from static_permission_module where flag = '$module'";
        $query = $this->CI->db->query($msql);
        $data = $query->first_row();
        
        if ( ! in_array($data->id, $modules)) {
            die('Access denied');
        }
    }

    /*
     * 判断权限
     */
    public function webHasAccess($module) {
    	$group_id = $this->CI->session->userdata ( 'webgroup' );
    	if (! $group_id) {
    		$url = '/index.php/web/login';
    		echo '<script type="text/javascript"> top.location.href = "' . $url . '"; </script>';
    		exit ();
    	} else {
    		$sql = 'select modules from static_permission_group where id = ' . $group_id;
    		$query = $this->CI->db->query ( $sql );
    		$result = $query->result_array ();
    		$modules = unserialize ( $result [0] ['modules'] );
    			
    		$msql = "select id from static_permission_module where flag = '$module'";
    		$query = $this->CI->db->query ( $msql );
    		$data = $query->first_row ();
    			
    		if (! in_array ( $data->id, $modules )) {
    			//die ( 'Access denied' );
    			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
    			echo "<script type='text/javascript'>alert('你暂无该页面管理权限');top.location.href = '/web/login/logout'; </script>";
    		}
    	}
    }
    
    private function goLogin($status)
    {
        if (!$status) {
            echo '<script type="text/javascript"> top.location.href = "/index.php/16835/login"; </script>';
            exit();
        }
    }
    
    public function webHasLogin()
    {
    	$islogin = $this->CI->session->userdata('weblogged_in');
    	if (!$islogin) {
            echo '<script type="text/javascript"> top.location.href = "/index.php/web/login"; </script>';
            exit();
        }
    }
}
