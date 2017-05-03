     
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>小组共修记录</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/group_stduy/save');?>" method="post" target="tarframe"  enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $model->id;?>" name="id" />
                          <div class="form_title pd10">
                             <h1>详情</h1>
                          </div>
                        	<div class="colforms"><dl>
								<dt>共修日期：<font class="red">*</font></dt><dd><?php if(empty($model->join_date)) echo "暂未填写";else echo $model->join_date;?></dd>
								<dt>参加共修人数：<font class="red">*</font></dt><dd><?php if(empty($model->join_count)) echo "暂未填写";else echo $model->join_count;?></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>缺勤人数：</dt><dd><?php if(empty($model->queqin_count)) echo "暂未填写";else echo $model->queqin_count;?></dd>
								<dt>请假人数：</dt><dd><?php if(empty($model->qingjia_count)) echo "暂未填写";else echo $model->qingjia_count;?></dd></dl>
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
     