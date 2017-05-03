<div class="rightpanel">
    <div class="mian"> 
        <!-- 面包屑 -->
        <div class="map">
            <div class="cb">
                <h1>账号管理</h1>
            </div>
        </div>
        <!-- end 面包屑 -->
        <form action="<?php echo site_url('admin/groups/edit');?>" method="post" >
            <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
            <!-- 表单 -->
            <div class="col_form mrtop">
                <div class="form_title pd10">
                    <h1>用户组信息</h1>
                    <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>组名：<font class="red">*</font></dt>
                        <dd>
                            <input type="text" name="name" class="btn_txt" value="<?php echo $item['name']?>"  />
                        </dd>
                        <dd class="error"></dd>
                    </dl>
                </div>
                <div class="col_forms">
                    <dl>
                        <dt>分组描述：<font class="red">*</font></dt>
                        <dd>
                            <textarea id="content" name="description" class="btn_textarea"><?php echo $item['description'] ?></textarea>
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
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