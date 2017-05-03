
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>届别</h1></div>
             </div>
          <!-- end 面包屑 -->
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/grade/add');?>" method="post" target="tarframe"  enctype="multipart/form-data">
                          <div class="form_title pd10">
                             <h1>添加</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                        	<div class="colforms"><dl>
								<dt>课程类型：<font class="red">*</font></dt><dd><select class="btn_txt" name="course_type">
                                	<option value="0">-全部-</option>
                                	<option value="1" >基础班</option>
                                	<option value="2" >加行班</option>
                                	<option value="3" >入行论</option>
                                	<option value="4" >净土班</option>
                                	<option value="5" >>五论班</option>
                                	<option value="6" >研究班</option>
                                	<option value="7" >念佛堂</option>
                                </select></dd>
								<dt>那一届：<font class="red">*</font></dt><dd>
								<select class="btn_txt" name="year">
                                	<option value="2016">2016</option>
                                	<option value="2017" >2017</option>
                                	<option value="2018" >2018</option>
                                	<option value="2019" >2019</option>
                                	<option value="2020" >2020</option>
                                	<option value="2021" >2021</option>
                                	<option value="2022" >2022</option>
                                	<option value="2023" >2023</option>
                                </select>
								</dd></dl>
							</div>

							<div class="colforms"><dl>
								<dt>备注：</dt><dd><input type="text" class="btn_txt" id="remark" name="remark" /></dd></dl>
							</div>
                          <div class="colforms">
                             <dl>
                                <dt>详细描述：<font class="red">*</font></dt>
                                <dd><textarea id="introduction" name="introduction" class="btn_textarea"></textarea></dd>
                             </dl>
                          </div>
                          <div class="clearfix"></div>
                          <div class="form_foot mrtop cb">
                            <input type="submit" value="确认提交" name="save" class="btn_blue"  />&nbsp;&nbsp; <input type="button" value="返回" onclick="history.go(-1);" class="btn_black"  />
                          </div>
                          </form>
						<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>
                   </div>
               <!-- end 表单 -->
              </div>
     </div>
