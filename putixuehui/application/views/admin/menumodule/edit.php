     
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>菜单管理</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/menumodule/save');?>" method="post" target="tarframe"  enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $model->id;?>" name="id" />
                          <div class="form_title pd10">
                             <h1>编辑</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                        	<div class="col_forms"><dl>
								<dt>父类id：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" value="<?php echo $model->pid;?>" id="pid" name="pid" /></dd></dl>
							</div>
							<div class="col_forms"><dl>
								<dt>名称：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" value="<?php echo $model->name;?>" id="name" name="name" /></dd></dl>
							</div>
							<div class="col_forms"><dl>
								<dt>标识：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" value="<?php echo $model->flag;?>" id="flag" name="flag" /></dd></dl>
							</div>
							<div class="col_forms"><dl>
								<dt>url：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" value="<?php echo $model->url;?>" id="url" name="url" /></dd></dl>
							</div>
                          <div class="clearfix"></div>
                          <div class="form_foot mrtop cb">
                            <input type="submit" value="确认提交" name="save" class="btn_blue" />&nbsp;&nbsp; <input type="button" value="返回" onclick="window.location = '/admin/menumodule/index'" class="btn_black"  />
                          </div>
                          </form>
						<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>
                   </div>
               <!-- end 表单 -->
              </div> 
     </div>
     