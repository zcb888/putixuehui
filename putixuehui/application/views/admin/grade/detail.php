     
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>届别</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/grade/save');?>" method="post" target="tarframe"  enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $model->id;?>" name="id" />
                          <div class="form_title pd10">
                             <h1>详情</h1>
                          </div>
                        	<div class="colforms"><dl>
								<dt>课程类型：<font class="red">*</font></dt><dd><?php if(empty($model->course_type)) echo "暂未填写";else echo $model->course_type;?></dd>
								<dt>那一届：<font class="red">*</font></dt><dd><?php if(empty($model->year)) echo "暂未填写";else echo $model->year;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>介绍：</dt><dd><?php if(empty($model->introduction)) echo "暂未填写";else echo $model->introduction;?></dd>
								<dt>管理备注：</dt><dd><?php if(empty($model->remark)) echo "暂未填写";else echo $model->remark;?></dd></dl>
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
     