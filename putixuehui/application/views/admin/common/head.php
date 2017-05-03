<div class="header">
    <div class="head_left">学会后台管理系统</div>
    <div class="head_right">
        <div class="pull_right">
            <ul>
                <!--<li><i class="icon1_w"></i><a href="#">12条</a></li>-->
                <li><a href="/admin/groups/changepwd"><?php echo $this->session->userdata ( 'loginname' );?></a></li>
                <li><a href="<?php echo site_url("admin/login/logout");?>">退出</a></li>
                <li><a href="/" target="_blank">访问前台</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- end header -->