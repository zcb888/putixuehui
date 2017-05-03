<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Group_stduy extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->thor->loginstate(100);
        $this->permission->hasLogin();
    }

    /*
     * 首页列表
     */
    public function index()
    {
        $this->permission->hasAccess ( 'group_stduy_index' );
        $pageindex = $this->input->get('per_page');
        $pageindex = empty($pageindex) ? 1 : $pageindex;
        $name = trim($this->input->get('name'));
        $startdate = trim($this->input->get('startdate'));
        $enddate = trim($this->input->get('enddate'));

        $url = "/admin/group_stduy/index?name=" . $name . "&startdate=" . $startdate . "&enddate=" . $enddate;

        $this->load->model('table/group_stduy_model');

        $group_id = 0;
        $admin_group = $this->thor->getgroup();
        if ($admin_group > 1) // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
            $group_id = $this->session->userdata('manger_group_id');
        $list = $this->group_stduy_model->search($name, $group_id, $startdate, $enddate, $pageindex);
        $count = $this->group_stduy_model->search_count($name, $group_id, $startdate, $enddate);

        $data = array (
                'name' => $name,
                'startdate' => $startdate,
                'enddate' => $enddate
        );

        $this->load->library('pagination');
        $config = $this->fun->page($url, $count, 20, $url, 4);
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['list'] = $list;

        $data['view'] = 'application/views/admin/group_stduy/index';
        $this->load->view('admin/common/frame', $data);
    }

    /*
     * 编辑
     */
    function edit($id)
    {
        // if ($id) {
        // $this->load->model('table/group_stduy_model');
        // $model = $this->group_stduy_model->getModelByPrimaryKey(array (
        // 'id' => $id
        // ));
        // $data['model'] = $model;
        // $data['view'] = 'application/views/admin/group_stduy/edit';
        // $this->load->view('admin/common/frame', $data);
        // }
        if ($id) {
            $this->load->model('table/group_stduy_model');
            $model = null;
            $this->db->where('id', $id);
            $admin_group = $this->thor->getgroup();
            if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
                $manger_group_id = $this->session->userdata('manger_group_id');
                $this->db->where('group_id', $manger_group_id);
            }
            $model = $this->db->get('group_stduy')->first_row();
            if ($model) {
                $data['model'] = $model;

                $this->db->select('id,name,leader');
                $admin_group = $this->thor->getgroup();
                if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
                    $manger_group_id = $this->session->userdata('manger_group_id');
                    $this->db->where('id', $manger_group_id);
                }
                $data['group_list'] = $this->db->get('group')->result_array();
                $data['view'] = 'application/views/admin/group_stduy/edit';
                $this->load->view('admin/common/frame', $data);
            } else {
                $this->load->library('publicverify');
                $this->publicverify->jsAlert('你暂无资格修改此数据！', 'admin/group_stduy/index');
            }
        }
    }

    /*
     * 展示
     */
    function detail($id)
    {
        if ($id) {
            $this->load->model('table/group_stduy_model');
            $model = $this->group_stduy_model->getModelByPrimaryKey(array (
                    'id' => $id
            ));
            $data['model'] = $model;
            $data['view'] = 'application/views/admin/group_stduy/detail';
            $this->load->view('admin/common/frame', $data);
        }
    }

    /*
     * 添加
     */
    public function add()
    {
        // $this->permission->webHasAccess ( 'group_stduy_add' );
        if (!empty($_POST)) {
            $this->load->library('publicverify');
            $join_date = trim($this->input->post('join_date'));
            $join_count = trim($this->input->post('join_count'));
            $queqin_count = trim($this->input->post('queqin_count'));
            $qingjia_count = trim($this->input->post('qingjia_count'));

            $bingjia_str = trim($this->input->post('bingjia_str'));
            $shijia_str = trim($this->input->post('shijia_str'));
            $chidao_str = trim($this->input->post('chidao_str'));
            $zaotui_str = trim($this->input->post('zaotui_str'));
            $host = trim($this->input->post('host'));
            $remark = trim($this->input->post('remark'));

            $group_id = trim($this->input->post('group_id'));
            $add_time = date('Y-m-d H:i:s');

            if (empty($join_date) || empty($join_count)) {
                $this->publicverify->jsAlert('请完整填写必填字段');
                exit();
            }
            $exist_model = $this->db->select('id')->where('group_id', $group_id)->where('join_date', $join_date)->get('group_stduy')->first_row();
            if (!$exist_model) {
                $this->load->model('table/group_stduy_model');
                $insert_data = array (
                        'group_id' => $group_id,
                        'join_date' => $join_date,
                        'join_count' => intval($join_count),
                        'queqin_count' => intval($queqin_count),
                        'qingjia_count' => intval($qingjia_count),
                        'admin_id' => $this->session->userdata('user_id'),
                        'bingjia_str' => $bingjia_str,
                        'shijia_str' => $shijia_str,
                        'chidao_str' => $chidao_str,
                        'zaotui_str' => $zaotui_str,
                        'remark' => $remark,
                        'host' => $host,
                        'add_time' => $add_time
                );
                $result = $this->group_stduy_model->insert($insert_data);
                if ($result > 0) {
                    $this->publicverify->jsAlert('提交成功！', 'admin/group_stduy/index');
                } else {
                    $this->publicverify->jsAlert('提交失败！', 'admin/group_stduy/add');
                }
            } else {
                $this->publicverify->jsAlert('不能重复提交！', 'admin/group_stduy/add');
            }
        } else {
            $this->db->select('id,name,leader');
            $admin_group = $this->thor->getgroup();
            if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能管理自己本组的学员
                $manger_group_id = $this->session->userdata('manger_group_id');
                $this->db->where('id', $manger_group_id);
            }
            $data['group_list'] = $this->db->get('group')->result_array();
            $data['view'] = 'application/views/admin/group_stduy/add';
            $this->load->view('admin/common/frame', $data);
        }
    }

    /*
     * 编辑保存
     */
    public function save()
    {
        if (!empty($_POST)) {
            $this->load->library('publicverify');
            if (isset($_POST['save'])) {
                $id = $this->input->post('id');
                $join_date = trim($this->input->post('join_date'));
                $join_count = trim($this->input->post('join_count'));
                $queqin_count = trim($this->input->post('queqin_count'));
                $qingjia_count = trim($this->input->post('qingjia_count'));
                $group_id = trim($this->input->post('group_id'));

                $bingjia_str = trim($this->input->post('bingjia_str'));
                $shijia_str = trim($this->input->post('shijia_str'));
                $chidao_str = trim($this->input->post('chidao_str'));
                $zaotui_str = trim($this->input->post('zaotui_str'));
                $host = trim($this->input->post('host'));
                $remark = trim($this->input->post('remark'));

                if (empty($join_date) || empty($join_count)) {
                    $this->publicverify->jsAlert('请完整填写必填字段');
                    exit();
                }
                $this->load->model('table/group_stduy_model');

                $update_data = array (
                        'group_id' => $group_id,
                        'join_date' => $join_date,
                        'join_count' => intval($join_count),
                        'queqin_count' => intval($queqin_count),
                        'qingjia_count' => intval($qingjia_count),
                        'bingjia_str' => $bingjia_str,
                        'shijia_str' => $shijia_str,
                        'chidao_str' => $chidao_str,
                        'remark' => $remark,
                        'host' => $host,
                        'zaotui_str' => $zaotui_str
                );
                $result = $this->group_stduy_model->update($update_data, array (
                        'id' => $id
                ));
                if ($result > 0) {
                    $this->publicverify->jsAlert('修改成功！', 'admin/group_stduy/index');
                } else {
                    $this->publicverify->jsAlert('修改失败！', 'admin/group_stduy/add');
                }
            } else {
                $this->publicverify->jsAlert('数据异常！！', 'admin/group_stduy/index');
            }
        }
    }

    /*
     * 删除
     */
    function del($id)
    {
        if ($id) {
            $this->load->model('table/group_stduy_model');
            $delete_array['id'] = $id;
            $is_delete = false;
            $admin_group = $this->thor->getgroup();
            if ($admin_group > 1) { // 如果权限组大于1，即非系统管理员，则只能删除自己本组的学员
                $manger_group_id = $this->session->userdata('manger_group_id');
                $sql = "select b.id from action a left join users b on a.user_id=b.id where a.id=$id and b.group_id=" . $manger_group_id;
                $model = $this->db->query($sql)->first_row();
                if ($model) {
                    $is_delete = true;
                }
            } else {
                $is_delete = true;
            }
            $this->load->library('publicverify');
            if ($is_delete) {
                $result = $this->group_stduy_model->delete($delete_array);
                $this->load->library('publicverify');
                if ($result > 0) {
                    $this->publicverify->jsAlert('删除成功！', 'admin/group_stduy/index');
                } else {
                    $this->publicverify->jsAlert('删除失败！', 'admin/group_stduy/index');
                }
            } else {
                $this->publicverify->jsAlert('你暂无资格删除该记录！', 'admin/group_stduy/index');
            }
        }
    }

}