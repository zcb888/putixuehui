<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>列表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/chapter/add"); ?>" class="btn_blue">添加</a></div>
                  	<br /><br />
               </div>
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
	                   	<td>ID</td>
						<td>届别ID</td>
						<td>开始日期</td>
						<td>结束日期</td>
						<td>法本</td>
						<td>章节</td>
						<td>排序</td>
						<td></td>
		                <td>操作</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                foreach($list as $item){?>
	                <tr>
                 		<td><?php echo $item["id"];?></td>
						<td><?php echo $item["grade_id"];?></td>
						<td><?php echo $item["start_date"];?></td>
						<td><?php echo $item["end_date"];?></td>
						<td><?php echo $item["book"];?></td>
						<td><?php echo $item["chapter"];?></td>
						<td><?php echo $item["sort"];?></td>
						<td><?php echo $item["add_time"];?></td> 
	                    <td>
						<a href="<?php echo base_url(); ?>admin/chapter/edit/<?php echo $item['id']; ?>"  title="修改"><i class="icon1_b"></i></a> &nbsp; &nbsp;
						<a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>admin/chapter/del/<?php echo $item['id']; ?>';}" title="删除"><i class="icon2_b"></i></a>
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