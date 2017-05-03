     
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>修量</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/action/save');?>" method="post" target="tarframe"  enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $model->id;?>" name="id" />
                          <div class="form_title pd10">
                             <h1>详情</h1>
                          </div>
                        	<div class="colforms"><dl>
								<dt>user_id：<font class="red">*</font></dt><dd><?php if(empty($model->user_id)) echo "暂未填写";else echo $model->user_id;?></dd>
								<dt>日期：<font class="red">*</font></dt><dd><?php if(empty($model->action_date)) echo "暂未填写";else echo $model->action_date;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>大头数量：<font class="red">*</font></dt><dd><?php if(empty($model->big_head)) echo "暂未填写";else echo $model->big_head;?></dd>
								<dt>小头数量：<font class="red">*</font></dt><dd><?php if(empty($model->small_head)) echo "暂未填写";else echo $model->small_head;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>磕头总数：<font class="red">*</font></dt><dd><?php if(empty($model->total_head)) echo "暂未填写";else echo $model->total_head;?></dd>
								<dt>备注：</dt><dd><?php if(empty($model->remark)) echo "暂未填写";else echo $model->remark;?></dd></dl>
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
     