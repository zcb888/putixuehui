     <script type="text/javascript" src="<?php echo base_url(); ?>style/plugin/jedate/jedate.js"></script>
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1></h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/chapter/save');?>" method="post" target="tarframe"  enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $model->id;?>" name="id" />
                          <div class="form_title pd10">
                             <h1>编辑</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                        	<div class="colforms"><dl>
								<dt>届别id：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="grade_id" name="grade_id" value="<?php echo $model->grade_id;?>" /></dd>
								<dt>开始日期：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="start_date" name="start_date" value="<?php echo $model->start_date;?>" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>结束日期：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="end_date" name="end_date" value="<?php echo $model->end_date;?>" /></dd>
								<dt>法本：</dt><dd><input type="text" class="btn_txt" id="book" name="book" value="<?php echo $model->book;?>" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>章节：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="chapter" name="chapter" value="<?php echo $model->chapter;?>" /></dd>
								<dt>排序：</dt><dd><input type="text" class="btn_txt" id="sort" name="sort" value="<?php echo $model->sort;?>" /></dd></dl>
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
		dateCell:"#start_date",
		format:"YYYY-MM-DD",
		isTime:false,
		minDate:"2012-09-19 00:00:00"
	});
	jeDate({
		dateCell:"#end_date",
		format:"YYYY-MM-DD",
		isTime:false,
		minDate:"2012-09-19 00:00:00"
	});
	</script>