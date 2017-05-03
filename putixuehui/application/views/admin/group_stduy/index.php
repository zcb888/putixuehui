<script type="text/javascript" src="<?php echo base_url(); ?>style/plugin/jedate/jedate.js"></script>
<script type="text/javascript">
    function search()
	{
		var name = $("#name").val();
		var startdate = $("#startdate").val();
		var enddate = $("#enddate").val();
		window.location= '/admin/group_stduy/index?name='+name+'&startdate='+startdate+'&enddate='+enddate;
	}
</script>
<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>小组共修记录列表</h1></div>
             </div>
           <!-- end 面包屑 -->

            <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/group_stduy/add"); ?>" class="btn_blue">添加</a></div>
               	   <span>小组名称:</span><input type="text" id="name" name="name" value="<?php echo $name;?>" class="btn_txt"  />
                  	<span>开始日期:</span><input type="text" id="startdate" name="startdate" value="<?php echo $startdate;?>" class="btn_txt"  />
                 <span>结束日期:</span><input type="text" id="enddate" name="enddate" value="<?php echo $enddate;?>" class="btn_txt"  />&nbsp;<input type="button" onclick="search();" class="btn-btn" value="搜索" />
               </div>
               <div class="col_tabs">
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
                        <td>小组名称</td>
	                   	<td>共修日期</td>
						<td>参加共修人数</td>
						<td>缺勤人数</td>
						<td>请假人数</td>
		                <td>操作</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                foreach($list as $item){?>
	                <tr>
	                   <td><?php echo $item["name"];?></td>
                 		<td><?php echo $item["join_date"];?></td>
						<td><?php echo $item["join_count"];?></td>
						<td><?php echo $item["queqin_count"];?></td>
						<td><?php echo $item["qingjia_count"];?></td>
	                    <td>
						<a href="<?php echo base_url(); ?>admin/group_stduy/edit/<?php echo $item['id']; ?>"  title="修改"><i class="icon1_b"></i></a> &nbsp; &nbsp;
						<a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>admin/group_stduy/del/<?php echo $item['id']; ?>';}" title="删除"><i class="icon2_b"></i></a>
	                    </td>
	                </tr>
	           		 <?php }}?>
                  </table>
                </div>
               <!-- end 表格 -->
                <!-- 翻页 -->
                 <div class="pages">
                     <?php echo $pagination; ?>
                 </div>
               <!-- end 翻页 -->
              </div>
     </div>
          <script type="text/javascript">
jeDate({
    dateCell:"#startdate",
    format:"YYYY-MM-DD",
    isTime:false,
    minDate:"2012-09-19"
})
jeDate({
    dateCell:"#enddate",
    format:"YYYY-MM-DD",
    isTime:false,
    minDate:"2012-09-19"
})
</script>