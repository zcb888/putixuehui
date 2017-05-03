<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CI_Xunsearch {

    private $xs;
    private $CI;

    /**
     * 两个索引库之间的平滑切换，需要linux定时错开生成索引库。
     */
    public function __construct() {
        $this->CI = & get_instance();
        require '/usr/local/xunsearch/sdk/php/lib/XS.php'; // 1.4.7
        $xs = new XS('aijiu');
        try {
            $s = $xs->search;
            //$s->dbTotal;
        } catch (Exception $e) {
            $xs = new XS('demo');
            error_log($e->getMessage() . '@' . time());
        }
        $this->xs = $xs;
        $this->doc = new XSDocument;
    }

    public function addIndex(Array $data) {
        $doc = new XSDocument;
        $doc->setFields($data);
        $index = $this->xs->index;
        $index->add($doc);
    }

    public function updateIndex(Array $data) {
        $doc = new XSDocument;
        $doc->setFields($data);
        $index = $this->xs->index;
        $index->update($doc);
    }

    /*
     * 下次修改数据库密码、项目名称一定记得要改此方法
     */

    function ExecuteIndex($appId) {
        if ($appId) {
            $exec_shell = '/usr/local/xunsearch/sdk/php/util/Indexer.php --source=mysql://yueappfmrom:yueappfmrom@2014@192.168.0.222:3306/yueapp --sql="SELECT app.app_id,app.is_gamepackage,app.packagenum,app.f_install_core as realinstallcount, app.isoperators as is_extend, app_info.app_name,app_info.app_logo, app_info.app_file,left(rtrim(app_info.app_description),30) as app_description, app_info.app_version,app_info.app_versioncode,app_info.app_size, app_info.app_star, app.package, ac.category_name as cat_name, ac.parent_id,app_info.downloadNums as downloadNums, app_info.comm_count,ishight,app_info.apikey FROM app INNER JOIN app_info ON app.appinfo_id = app_info.appinfo_id INNER JOIN app_categories ac ON app_info.categories_id = ac.category_id where is_publish=1 AND app.app_id=' . $appId . '" --project=test;';
            exec($exec_shell);
        }
    }

    /**
     * 本方法目前只能按主键删除
     */
    public function dropIndex($primary_key) {
        $index = $this->xs->index;
        $index->del($primary_key);
    }

    public function search() {
        return $this->xs->search;
    }

}