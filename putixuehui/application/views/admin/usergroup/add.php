     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>小组</h1></div> 
             </div>
               <!-- end 面包屑 -->
              <!-- 表单 -->
              <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/usergroup/add');?>" method="post" target="tarframe"  enctype="multipart/form-data">
                   <div class="col_form mrtop">
                          <div class="form_title pd10">
                             <h1>添加</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                          <div class="col_forms">
                             <dl>
                                <dt>小组名称：<font class="red">*</font></dt>
                                <dd><input type="text" class="btn_txt" name="name"  /></dd>
                                <!--<dd class="error">信息填写错误！</dd> -->
                             </dl>
                          </div>
                         <div class="col_forms">
                             <dl>
                                <dt>组长：<font class="red">*</font></dt>
                                <dd><input type="text" class="btn_txt"  name="leader"  /></dd>
                                <!--<dd class="error">信息填写错误！</dd> -->
                             </dl>
                          </div>
                            <div class="col_forms">
                             <dl>
                                <dt>所在区域：<font class="red">*</font></dt>
                              <?php echo $region; ?>
			                  <?php echo $city; ?>
			                  <?php echo $district; ?>
                   <!--<dd class="error">信息填写错误！</dd>-->
                             </dl>
                          </div>
                           <div class="col_forms">
                             <dl>
                                <dt>具体地址：<font class="red">*</font></dt>
                                <dd><input type="text" class="btn_txt" name="address" style="width:360px;" /></dd>
                             </dl>
                          </div>
                          <div class="form_foot mrtop">
                            <input type="submit" value="确认提交" class="btn_blue"  />&nbsp;&nbsp; <input type="button" onclick="history.go(-1);" value="返回" class="btn_black"  />
                          </div>
                          <div class="clearfix"></div>
                   </div>
                   </form>
               <!-- end 表单 -->  
              </div><!-- end mian --> 
     </div><!-- end 右侧 -->
     <script type="text/javascript" src="<?php echo base_url(); ?>style/js/area.js"></script>
<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>