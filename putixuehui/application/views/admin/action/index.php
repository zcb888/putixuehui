<script type="text/javascript" src="<?php echo base_url(); ?>style/plugin/jedate/jedate.js"></script>
<script type="text/javascript">
    function search()
	{
		var name = $("#name").val();
		var startdate = $("#startdate").val();
		var enddate = $("#enddate").val();	
		window.location= '/admin/action/index?name='+name+'&startdate='+startdate+'&enddate='+enddate;
	}
</script>
<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>修量列表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/action/add"); ?>" class="btn_blue">添加</a></div>
               	   <span>姓名:</span><input type="text" id="name" name="name" value="<?php echo $name;?>" class="btn_txt"  />
                  	<span>开始日期:</span><input type="text" id="startdate" name="startdate" value="<?php echo $startdate;?>" class="btn_txt"  />
                 <span>结束日期:</span><input type="text" id="enddate" name="enddate" value="<?php echo $enddate;?>" class="btn_txt"  />&nbsp;<input type="button" onclick="search();" class="btn-btn" value="搜索" />
               </div>
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
	                   	<td>姓名</td>
						<td>日期</td>
						<td>磕头总数</td>
						<td>大头数量</td>
						<td>小头数量</td>
						<td>文殊心咒</td>
						<td>怀业祈祷文</td>
						<td>观修</td>
						<td width="15%">提交时间</td>
		                <td>操作</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                foreach($list as $item){?>
	                <tr>
                 		<td><a target="_blank" href="/index/detail?user_id=<?php echo $item['user_id'];?>"><?php echo $item["name"];?></a></td>
						<td><a target="_blank" href="/index/result?date=<?php echo $item['action_date'];?>"><?php echo $item["action_date"];?></a></td>
						<td><?php echo $item["total_head"];?></td>
						<td><?php echo $item["big_head"];?></td>
						<td><?php echo $item["small_head"];?></td>
						<td><?php echo $item["wenshu"];?></td>
						<td><?php echo $item["huaiye"];?></td>
						<td><?php echo $item["guanxiu"];?></td>
						<td><?php echo $item["add_time"];?></td> 
	                    <td>
						<a href="<?php echo base_url(); ?>admin/action/edit/<?php echo $item['id']; ?>"  title="修改"><i class="icon1_b"></i></a> &nbsp; &nbsp;
						<a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>admin/action/del/<?php echo $item['id']; ?>';}" title="删除"><i class="icon2_b"></i></a>
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