     <script type="text/javascript" src="<?php echo base_url(); ?>style/plugin/jedate/jedate.js"></script>
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
                             <h1>编辑</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                        	<div class="colforms"><dl>
								<dt>用户id：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="user_id" name="user_id" value="<?php echo $model->user_id;?>" /></dd>
								<dt>姓名：</dt><dd><input type="text" class="btn_txt" id="name" name="name" value="<?php echo $model->name;?>" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>班级id：</dt><dd><input type="text" class="btn_txt" id="group_id" name="group_id" value="<?php echo $model->group_id;?>" /></dd>
								<dt>章节id：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="chapter_id" name="chapter_id" value="<?php echo $model->chapter_id;?>" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>是否参加共修：<font class="red">*</font></dt><dd><select class="btn_txt" name="is_join">
                                	<option value="1" <?php if($model->is_join ==1) echo "selected = 'true'"; ?>>是</option>
                                	<option value="2" <?php if($model->is_join ==2) echo "selected = 'true'"; ?>>否</option>
                                </select></dd>
								<dt>传承是否全部完成：</dt><dd><select class="btn_txt" name="is_all_ok">
                                	<option value="1" <?php if($model->is_all_ok ==1) echo "selected = 'true'"; ?>>是</option>
                                	<option value="2" <?php if($model->is_all_ok ==2) echo "selected = 'true'"; ?>>否</option>
                                </select></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>全部完成时间：</dt><dd><input type="text" class="btn_txt" id="all_ok_date" name="all_ok_date" value="<?php echo $model->all_ok_date;?>" /></dd>
								<dt>操作员id：</dt><dd><input type="text" class="btn_txt" id="operation_user_id" name="operation_user_id" value="<?php echo $model->operation_user_id;?>" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>是否请假：</dt><dd><select class="btn_txt" name="is_licence">
                                	<option value="1" <?php if($model->is_licence ==1) echo "selected = 'true'"; ?>>是</option>
                                	<option value="2" <?php if($model->is_licence ==2) echo "selected = 'true'"; ?>>否</option>
                                </select></dd>
								<dt>请假原因：</dt><dd><input type="text" class="btn_txt" id="reason" name="reason" value="<?php echo $model->reason;?>" /></dd></dl>
							</div>
                          <div class="clearfix"></div>
                          <div class="form_foot mrtop cb">
                            <input type="submit" value="确认提交" name="save" class="btn_blue" />&nbsp;&nbsp; <input type="button" value="返回" onclick="history.go(-1);" class="btn_black"  />
                          </div>
                          </form>
						<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>
                   </div>
               <!-- end 表单 -->
              </div> 
     </div>
     <script type="text/javascript">
	jeDate({
		dateCell:"#all_ok_date",
		format:"YYYY-MM-DD",
		isTime:false,
		minDate:"2012-09-19 00:00:00"
	});
	</script>