<script type="text/javascript">
    function search()
	{
		var name = $("#name").val();
		var phone = $("#phone").val();
		window.location= '/admin/users/index?name='+name+'&phone='+phone;
	}
</script>
<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>学员列表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/users/add"); ?>" class="btn_blue">添加</a>&nbsp;&nbsp;<a href="<?php echo site_url("admin/users/export"); ?>" class="btn_blue">导出</a></div>
                  	<span>姓名:</span><input type="text" id="name" name="name" value="<?php echo $name;?>" class="btn_txt"  /><span>手机号码:</span><input type="text" id="phone" name="phone" value="<?php echo $phone;?>" class="btn_txt"  />&nbsp;<input type="button" onclick="search();" class="btn-btn" value="搜索" />
               </div>
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
	                   	<td width="4%">序号</td>
						<td>姓名</td>
						<td width="4%">状态</td>
						<td>累计磕头总数</td>
						<td>累计文殊心咒</td>
						<td>累计怀业祈祷文</td>
						<td>手机号码</td>
						<td>邮箱</td>
		                <td>操作</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                	$index = 0;
	                foreach($list as $item){?>
	                <tr>
                 		<td><?php echo $item["id"];?></td>
						<td><a target="_blank" href="/index/detail?user_id=<?php echo $item['id'];?>"><?php echo $item["name"];?></a></td>
						<td><?php if($item['status']==-1) echo '<font color="red">移除</font>';else if($item['status']==2) echo '<font color="yellow">冻结</font>';else echo '正常';?></td>
						<td><?php if($item["total_head"]==0){?><font color="red"><?php echo $item["total_head"];?></font><?php }else{ echo $item["total_head"];}?></td>
						<td><?php echo $item["wenshu"];?></td>
						<td><?php echo $item["huaiye"];?></td>
						<td><?php echo $item["phone"];?></td>
						<td><?php echo $item["email"];?></td> 
	                    <td>
						<a href="<?php echo base_url(); ?>admin/users/edit/<?php echo $item['id']; ?>"  title="修改"><i class="icon1_b"></i></a> &nbsp; &nbsp;
						<a href="javascript:if(confirm('你确定要移除吗？')){ window.location.href='<?php echo base_url(); ?>admin/users/del/<?php echo $item['id']; ?>';}" title="移除"><i class="icon2_b"></i></a>
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