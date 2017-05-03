<script type="text/javascript">
    function search()
	{
		var name = $("#name").val();
		var group_id = $("#group_id").val();
		var is_all_ok = $("#is_all_ok").val();
		window.location= '/admin/study_record/index?name='+name+'&group_id='+group_id+'&is_all_ok='+is_all_ok;
	}
</script>
<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>学习共修记录列表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/study_record/add"); ?>" class="btn_blue">添加</a></div>
                  	<span>姓名:</span><input type="text" id="name" name="name" value="<?php echo $name;?>" class="btn_txt"  /><span>班级ID:</span><input type="text" id="group_id" name="group_id" value="<?php echo $group_id;?>" class="btn_txt"  /><span>传承是否全部完成:</span><select id="is_all_ok" name="is_all_ok" class="btn_select" /><option value="0">-全部-</option><option value="1" <?php if($is_all_ok ==1) echo "selected = 'true'"; ?>>是</option><option value="2" <?php if($is_all_ok ==2) echo "selected = 'true'"; ?>>否</option></select>&nbsp;<input type="button" onclick="search();" class="btn-btn" value="搜索" />
               </div>
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
	                   	<td>ID</td>
						<td>姓名</td>
						<td>章节ID</td>
						<td>是否参加共修</td>
						<td>传承是否全部完成</td>
						<td>是否请假</td>
						<td>请假原因</td>
		                <td>操作</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                foreach($list as $item){?>
	                <tr>
                 		<td><?php echo $item["id"];?></td>
						<td><?php echo $item["name"];?></td>
						<td><?php echo $item["chapter_id"];?></td>
						<td><?php echo $item["is_join"];?></td>
						<td><?php echo $item["is_all_ok"];?></td>
						<td><?php echo $item["is_licence"];?></td>
						<td><?php echo $item["reason"];?></td> 
	                    <td>
						<a href="<?php echo base_url(); ?>admin/study_record/edit/<?php echo $item['id']; ?>"  title="修改"><i class="icon1_b"></i></a> &nbsp; &nbsp;
						<a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>admin/study_record/del/<?php echo $item['id']; ?>';}" title="删除"><i class="icon2_b"></i></a>
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