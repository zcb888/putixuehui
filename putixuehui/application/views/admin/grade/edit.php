
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
                             <h1>编辑</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                        	<div class="colforms"><dl>
								<dt>课程类型：<font class="red">*</font></dt><dd><select class="btn_txt" name="course_type">
                                	<option value="0">-全部-</option>
                                	<option value="1" <?php if($model->course_type ==1) echo "selected = 'true'"; ?>>基础班</option>
                                	<option value="2" <?php if($model->course_type  ==2) echo "selected = 'true'"; ?>>加行班</option>
                                	<option value="3" <?php if($model->course_type  ==3) echo "selected = 'true'"; ?>>入行论</option>
                                	<option value="4" <?php if($model->course_type  ==4) echo "selected = 'true'"; ?>>净土班</option>
                                	<option value="5" <?php if($model->course_type  ==5) echo "selected = 'true'"; ?>>五论班</option>
                                	<option value="6" <?php if($model->course_type  ==6) echo "selected = 'true'"; ?>>研究班</option>
                                	<option value="7" <?php if($model->course_type  ==7) echo "selected = 'true'"; ?>>念佛堂</option>
                                </select></dd>
								<dt>那一届：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="year" name="year" value="<?php echo $model->year;?>" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>备注：</dt><dd><input type="text" class="btn_txt" id="remark" name="remark" value="<?php echo $model->remark;?>" /></dd></dl>
							</div>
                          <div class="colforms">
                             <dl>
                                <dt>详细描述：<font class="red">*</font></dt>
                                <dd><textarea id="introduction" name="introduction" class="btn_textarea"><?php echo $model->introduction;?></textarea></dd>
                             </dl>
                          </div>
                                                      <div class="colforms">
                             <dl>
                                <dt>处理记录如下：</dt>
                             </dl>
                          </div>
                           <div class="add-wages">
                           <?php if($record_list && count($record_list)>0){
                            	foreach ($record_list as $item){
                           ?>
                             <ul>
                               <li style="border: none;"><?php echo str_replace('00:00:00', '', $item['date_time']);?></li>
                               <li style="border: none;"><?php echo $item['admin_name'];?></li>
                               <li style="border: none;width:300px;"><?php echo $item['message'];?></li>
                               <li style="border: none;"><?php if($item['files']) {
                               	$index = 0 ;
                                foreach ($item['files'] as $file){
                                	if(!empty($file)){
										$index ++;
                                		echo '<a target="_blank" href="'.$file.'">文件'.$index.'</a>&nbsp;&nbsp;';
                                	}
                                }
                               }else{echo '暂无文件'; }?>&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>web/information/delprocess/<?php echo $item['id']; ?>/<?php echo $model->id;?>';}" title="删除">删除</a></li>
                             </ul>
                             <?php }}?>
                             <div class="wageslist cb"><div><input type="text" id="extend_date" name="extend[]" value="<?php echo date('Y-m-d');?>" /><input type="text" name="extend[]" value="<?php echo $this->session->userdata ( 'webname' );?>" /><input type="text" style="width:400px;" name="extend[]" value="" /><input type="file" multiple name="files_pdf0[]" value="" /></div>
                             </div>
                          </div>
                          <div class="cb add-wages-btn yj">+继续添加+</div>
                          <script>
                            $(function(){
                                var rowindex = 0;
								  $(".add-wages-btn").click(function(){
									  rowindex++;
									    var adddiv = document.createElement("div");
										var str ='<input type="text" id="extend_date'+rowindex+'" name="extend[]" value="<?php echo date('Y-m-d');?>" /><input type="text" name="extend[]" value="<?php echo $this->session->userdata ( 'webname' );?>" /><input type="text" style="width:400px;" name="extend[]" value="" /><input type="file" multiple name="files_pdf'+rowindex+'[]" value="" />';
										adddiv.innerHTML = str;
										$(".add-wages").append(adddiv).addClass("wageslist");

										jeDate({
										    dateCell:"#extend_date"+rowindex,
										    format:"YYYY-MM-DD",
										    isTime:false,
										    minDate:"2012-09-19"
										})
									  })
								})
                          </script>
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
