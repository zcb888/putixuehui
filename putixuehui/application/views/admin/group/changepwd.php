<div class="rightpanel">
    <div class="mian"> 
        <!-- 面包屑 -->
        <div class="map">
            <div class="cb">
                <h1>修改密码</h1>
            </div>
        </div>
        <!-- end 面包屑 -->
        <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/groups/changepwd'); ?>" method="post" >
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
                            <?php echo $username?>
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>原密码：<font class="red">*</font></dt>
                        <dd>
                            <input type="password" name="old_password" class="btn_txt" />
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>新密码：<font class="red">*</font></dt>
                        <dd>
                            <input type="password" name="admin_password" class="btn_txt" />
                        </dd>
                    </dl>
                </div>
                <div class="form_foot mrtop">
                    <input type="submit" value="确认提交" name="save" class="btn_blue"  />
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- end 表单 -->
        </form>
    </div>
    <!-- end mian --> 
</div>
<!-- end 右侧 -->
<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>