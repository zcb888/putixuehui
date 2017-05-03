     
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
                             <h1>详情</h1>
                          </div>
                        	<div class="colforms"><dl>
								<dt>届别id：<font class="red">*</font></dt><dd><?php if(empty($model->grade_id)) echo "暂未填写";else echo $model->grade_id;?></dd>
								<dt>开始日期：<font class="red">*</font></dt><dd><?php if(empty($model->start_date)) echo "暂未填写";else echo $model->start_date;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>结束日期：<font class="red">*</font></dt><dd><?php if(empty($model->end_date)) echo "暂未填写";else echo $model->end_date;?></dd>
								<dt>法本：</dt><dd><?php if(empty($model->book)) echo "暂未填写";else echo $model->book;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>章节：<font class="red">*</font></dt><dd><?php if(empty($model->chapter)) echo "暂未填写";else echo $model->chapter;?></dd>
								<dt>排序：</dt><dd><?php if(empty($model->sort)) echo "暂未填写";else echo $model->sort;?></dd></dl>
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
     