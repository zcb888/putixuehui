     <script type="text/javascript" src="<?php echo base_url(); ?>style/plugin/jedate/jedate.js"></script>
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>小组共修记录</h1></div>
             </div>
          <!-- end 面包屑 -->
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/group_stduy/add');?>" method="post" target="tarframe"  enctype="multipart/form-data">
                          <div class="form_title pd10">
                             <h1>添加</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项，缺勤指未履行请假手续&nbsp;)</p>
                          </div>
                             <div class="colforms"><dl>
								<dt>小组：</dt><dd>
								<select name="group_id" class="btn_txt" >
                                <?php
                                if($group_list && count($group_list)>0){
                                foreach($group_list as $list){?>
                                <option value="<?php echo $list['id']?>"><?php echo $list['name']?>【组长：<?php echo $list['leader'];?>】</option>
                                <?php }};?>
                            </select>
								</dd>
								<dt>共修日期：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="join_date" name="join_date" /></dd>
								</dl>
							</div>
                        	<div class="colforms"><dl>
								<dt>共修人数：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="join_count" name="join_count" /></dd>
							    <dt>缺勤人数：</dt><dd><input type="text" class="btn_txt" id="queqin_count" name="queqin_count" />(未请假)</dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>请假人数：</dt><dd><input type="text" class="btn_txt" id="qingjia_count" name="qingjia_count" /></dd>
								<dt>主持人：</dt><dd><input type="text" class="btn_txt" id="host" name="host" /></dd></dl>
							</div>
							<div class="colforms">
                             <dl>
                                <dt>病假姓名：</dt>
                                <dd><input type="text" class="btn_txt" name="bingjia_str" style="width:660px;" /></dd>
                             </dl>
                          </div>
                          <div class="colforms">
                             <dl>
                                <dt>事假姓名：</dt>
                                <dd><input type="text" class="btn_txt" name="shijia_str" style="width:660px;" /></dd>
                             </dl>
                          </div>
                          <div class="colforms">
                             <dl>
                                <dt>迟到姓名：</dt>
                                <dd><input type="text" class="btn_txt" name="chidao_str" style="width:660px;" /></dd>
                             </dl>
                          </div>
                          <div class="colforms">
                             <dl>
                                <dt>早退姓名：</dt>
                                <dd><input type="text" class="btn_txt" name="zaotui_str" style="width:660px;" /></dd>
                             </dl>
                          </div>
                           <div class="colforms">
                             <dl>
                                <dt>备注：</dt>
                                <dd><textarea id="remark" name="remark" class="btn_textarea"></textarea></dd>
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
     <script type="text/javascript">
	jeDate({
		dateCell:"#join_date",
		format:"YYYY-MM-DD",
		isTime:false,
		minDate:"2012-09-19 00:00:00"
	});
	</script>