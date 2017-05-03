     
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>学习共修记录</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/study_record/save');?>" method="post" target="tarframe"  enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $model->id;?>" name="id" />
                          <div class="form_title pd10">
                             <h1>详情</h1>
                          </div>
                        	<div class="colforms"><dl>
								<dt>用户id：<font class="red">*</font></dt><dd><?php if(empty($model->user_id)) echo "暂未填写";else echo $model->user_id;?></dd>
								<dt>姓名：</dt><dd><?php if(empty($model->name)) echo "暂未填写";else echo $model->name;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>班级id：</dt><dd><?php if(empty($model->group_id)) echo "暂未填写";else echo $model->group_id;?></dd>
								<dt>章节id：<font class="red">*</font></dt><dd><?php if(empty($model->chapter_id)) echo "暂未填写";else echo $model->chapter_id;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>是否参加共修：<font class="red">*</font></dt><dd><?php if(empty($model->is_join)) echo "暂未填写";else echo $model->is_join;?></dd>
								<dt>传承是否全部完成：</dt><dd><?php if(empty($model->is_all_ok)) echo "暂未填写";else echo $model->is_all_ok;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>全部完成时间：</dt><dd><?php if(empty($model->all_ok_date)) echo "暂未填写";else echo $model->all_ok_date;?></dd>
								<dt>操作员id：</dt><dd><?php if(empty($model->operation_user_id)) echo "暂未填写";else echo $model->operation_user_id;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>是否请假：</dt><dd><?php if(empty($model->is_licence)) echo "暂未填写";else echo $model->is_licence;?></dd>
								<dt>请假原因：</dt><dd><?php if(empty($model->reason)) echo "暂未填写";else echo $model->reason;?></dd></dl>
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
     