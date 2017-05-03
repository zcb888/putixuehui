     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>添加权限组</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
       <form name="groupFrom" id="groupFrom" action="<?php echo site_url('admin/groups/create');?>" method="post">
                          <div class="form_title pd10">
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                          <div class="col_forms">
                             <dl>
                                <dt>组名称：<font class="red">*</font></dt>
                                <dd><input type="text" class="btn_txt" id="name" name="name"  style="width:500px;" title="请输入名称" /></dd>
                                <!-- <dd class="error">信息填写错误！</dd> -->
                             </dl>
                          </div>
                          
                          <div class="col_forms">
                             <dl>
                                <dt>分组描述：</dt>
                                <dd><textarea id="content" name="description" class="btn_textarea"></textarea></dd>
                             </dl>
                          </div>
                          <div class="clearfix"></div>
                          <div class="form_foot mrtop cb">
                            <input type="submit" value="确认提交" name="save" class="btn_blue"  />&nbsp;&nbsp; <input type="button" value="返回" onclick="history.go(-1);" class="btn_black"  />
                          </div>
                          </form>
						<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>
                   </div>
               <!-- end 表单 -->
              </div><!-- end mian --> 
     </div><!-- end 右侧 -->
