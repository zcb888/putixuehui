<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * date:2014-09-11
 * desc:管理员登录后首页
 * author:Gavin.zhang
 */
class Index extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
		$this->thor->loginstate ( 100 );
		$this->permission->hasLogin ();
    }
    public function index(){
    	   	//管理员名字
    	$this->load->model('permission/Admin','admin');
        $data['username']=$this->admin->getAdminName();
        //左侧菜单
        $this->load->model('permission/Menu','menu');
        $data['menu'] = $this->menu->menuData();
        $data['first'] = $this->menu->first();
        $this->load->view('admin/index',$data);
    }
}