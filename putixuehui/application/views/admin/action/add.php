     <script type="text/javascript" src="<?php echo base_url(); ?>style/plugin/jedate/jedate.js"></script>
     <div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>修量</h1></div> 
             </div>
          <!-- end 面包屑 -->     
              <!-- 表单 -->
                   <div class="col_form mrtop">
                   <form name="uploadFrom" id="uploadFrom" action="<?php echo site_url('admin/action/add');?>" method="post" target="tarframe"  enctype="multipart/form-data">
                          <div class="form_title pd10">
                             <h1>添加</h1>
                             <p>(&nbsp;友情提示：带 * 的内容都是必填项&nbsp;)</p>
                          </div>
                        	<div class="col_forms"><dl>
								<dt>姓名：<font class="red">*</font></dt><dd>
								      <?php if($user_list && count($user_list)>0){
						      		foreach ($user_list as $item){
						       ?>
						      <label class="radio inline">
						        <input type="radio" value="<?php echo $item['id'];?>" name="user_id" >
						        <?php echo $item['name'];?>
						      </label>
						      <?php }} ?>
								</dd>
							</dl>
							</div>
							<div class="colforms"><dl>
								<dt>大头数量：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="big_head" value="0" name="big_head" /></dd>
								<dt>小头数量：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="small_head" value="0"  name="small_head" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>文殊心咒：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="wenshu" value="0" name="wenshu" /></dd>
								<dt>怀业祈祷文：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="huaiye" value="0"  name="huaiye" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>观修：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" id="guanxiu"  name="guanxiu" /></dd>
								<dt>日期：<font class="red">*</font></dt><dd><input type="text" class="btn_txt" value="<?php echo date('Y-m-d')?>" id="action_date" name="action_date" /></dd></dl>
							</div>
							<div class="colforms"><dl>
								<dt>备注：</dt><dd><input type="text" class="btn_txt" id="remark" name="remark" /></dd></dl>
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
		dateCell:"#action_date",
		format:"YYYY-MM-DD",
		isTime:false,
		minDate:"2012-09-19 00:00:00"
	});
	</script>