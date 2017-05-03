<div class="rightpanel">
    <div class="mian"> 
        <!-- 面包屑 -->
        <div class="map">
            <div class="cb">
                <h1>新增帐号</h1>
            </div>
        </div>
        <!-- end 面包屑 -->
        <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/groups/adminadd');?>" method="post" >
            <!-- 表单 -->
            <div class="col_form mrtop">
                <div class="form_title pd10">
                    <h1>管理员信息</h1>
                    <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>账号：<font class="red">*</font></dt>
                        <dd>
                            <input type="text" name="admin_username" class="btn_txt"  />
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                 <div class="col_forms">
                    <dl>
                        <dt>email：<font class="red">*</font></dt>
                        <dd>
                            <input type="text" name="email" class="btn_txt"  />
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>姓名：<font class="red">*</font></dt>
                        <dd>
                            <input type="text" name="name" class="btn_txt" />
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>密码：<font class="red">*</font></dt>
                        <dd>
                            <input type="password" name="admin_password" class="btn_txt" />
                        </dd>
                    </dl>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>权限：<font class="red">*</font></dt>
                        <dd>
                            <select name="permissions" class="btn_txt">
                                <?php foreach($perlist as $list):?>
                                <option value="<?php echo $list['id']?>"><?php echo $list['name']?></option>
                                <?php endforeach;?>
                            </select>
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                 <div class="col_forms">
                    <dl>
                        <dt>管理小组：<font class="red">*</font></dt>
                        <dd>
                            <select name="manger_group_id" class="btn_txt" >
                                <?php 
                                if($group_list && count($group_list)>0){
                                foreach($group_list as $list){?>
                                <option value="<?php echo $list['id']?>"><?php echo $list['name']?>【组长：<?php echo $list['leader'];?>】</option>
                                <?php }};?>
                            </select>
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                <div class="clearfix"></div>
                <div class="form_foot mrtop">
                    <input type="submit" value="确认提交" name="save" class="btn_blue"  />
                    &nbsp;&nbsp;
                    <input type="button" value="返回" onclick="history.go(-1);" class="btn_black"  />
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- end 表单 -->
        </form>
    </div>
    <!-- end mian --> 
</div>
<!-- end 右侧 -->