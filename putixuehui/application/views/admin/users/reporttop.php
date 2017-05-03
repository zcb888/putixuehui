<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>修量排行榜</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <div class="tabform">
                   <div class="fr addbtn">&nbsp;&nbsp;<a href="<?php echo site_url("admin/users/topexport"); ?>" class="btn_blue">导出</a></div>
              <br /> <br />
               </div>
               <!-- 表格 -->
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
	                   	<td>名次</td>
						<td>姓名</td>
						<td>累计磕头总数</td>
		                <td>整体进度</td>
		                <td>累计文殊心咒</td>
		                <td>累计怀业祈祷文</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                	
	                	$index =($pageindex -1)*30;
	                foreach($list as $item){ $index++;?>
	                <tr>
                 		<td><?php echo $index;?></td>
						<td><a target="_blank" href="/index/detail?user_id=<?php echo $item['id'];?>"><?php echo $item["name"];?></a></td>
						<td><?php if($item["total_head"]==0){?><font color="red"><?php echo $item["total_head"];?></font><?php }else{ echo $item["total_head"];}?></td>
						<td><?php echo $item["total_head"]/1000 ?>%</td>
						<td><?php echo $item["wenshu"] ?></td>
						<td><?php echo $item["huaiye"] ?></td>
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