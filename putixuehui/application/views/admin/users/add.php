     
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>学员</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/users/add');?>" method="post" target="tarframe"  enctype="multipart/form-data">
                          <div class="form_title pd10">
                             <h1>添加</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项,密码不填默认为：123456&nbsp;)</p>
                          </div>
                        	<div class="colforms"><dl>
								<dt>姓名：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="name" name="name" /></dd>
								<dt>小组：</dt><dd>
								<select name="group_id" class="btn_txt" >
                                <?php 
                                if($group_list && count($group_list)>0){
                                foreach($group_list as $list){?>
                                <option value="<?php echo $list['id']?>"><?php echo $list['name']?>【组长：<?php echo $list['leader'];?>】</option>
                                <?php }};?>
                            </select>
								</dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>手机号码：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="phone" name="phone" /></dd>
								<dt>登录密码：</dt><dd><input type="password" class="btn_txt" id="password" name="password" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>邮箱：</dt><dd><input type="text" class="btn_txt" id="email" name="email" /></dd></dl>
							</div>
                          <div class="clearfix"></div>
                          <div class="form_foot mrtop cb">
                            <input type="submit" value="确认提交" name="save" class="btn_blue"  />&nbsp;&nbsp; <input type="button" value="返回" onclick="history.go(-1);" class="btn_black"  />
                          </div>
                          </form>
						<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>
                   </div>
               <!-- end 表单 -->
              </div>
     </div>
     