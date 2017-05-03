     
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>修量</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/users/save');?>" method="post" target="tarframe"  enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $model->id;?>" name="id" />
                          <div class="form_title pd10">
                             <h1>详情</h1>
                          </div>
                        	<div class="colforms"><dl>
								<dt>姓名：<font class="red">*</font></dt><dd><?php if(empty($model->name)) echo "暂未填写";else echo $model->name;?></dd>
								<dt>手机号码：</dt><dd><?php if(empty($model->phone)) echo "暂未填写";else echo $model->phone;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>邮箱：</dt><dd><?php if(empty($model->email)) echo "暂未填写";else echo $model->email;?></dd></dl>
							</div>
                          <div class="clearfix"></div>
                          <div class="form_foot mrtop cb">
                            <input type="button" value="返回" onclick="history.go(-1);" class="btn_black"  />
                          </div>
                          </form>
						<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>
                   </div>
               <!-- end 表单 -->
              </div> 
     </div>
     