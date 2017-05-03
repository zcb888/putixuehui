<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1><?php if($type==1) echo '上周';else if($type==2)echo '本周';else if($type==3)echo '上月';else if($type==4)echo '本月';?>修量报表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <div class="tabform">
                   <div class="fr addbtn">
                   <?php 
                   $next_week_start= date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")));
                   $next_week_end = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y")));
                   $this_week_start= date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y")));
                   $this_week_end= date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")));
                   $next_month_start= date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y")));
                   $next_month_end= date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y")));
                    
                   $this_month_start= date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
                   $this_month_end = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y")));
                    
                   ?>
                   <a href="<?php echo site_url("admin/action/weekreport?type=1");?>" >上周</a>&nbsp;&nbsp;
                   <a href="<?php echo site_url("admin/action/weekreport?type=2");?>" >本周</a>&nbsp;&nbsp;
                   <a href="<?php echo site_url("admin/action/weekreport?type=3");?>" >上月</a>&nbsp;&nbsp;
                   <a href="<?php echo site_url("admin/action/weekreport?type=4");?>" >本月</a>
                   
                   </div>
                    <span>开始时间:<?php echo $startdate;?></span> <span>结束时间:<?php echo $enddate;?></span>
              <br /> <br />
               </div>
               <!-- 表格 -->
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
                    	<td>名次</td>
	                   	<td>姓名</td>
						<td><?php if($type==1) echo '上周';else if($type==2)echo '本周';else if($type==3)echo '上月';else if($type==4)echo '本月';?>磕头合计</td>
						<td>累计磕头总数</td>
		                <td>整体进度</td>
		                <td><?php if($type==1) echo '上周';else if($type==2)echo '本周';else if($type==3)echo '上月';else if($type==4)echo '本月';?>观修合计</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                	$index = 0;
	                foreach($list as $item){ $index++?>
	                <tr>
	                	<td><?php echo $index;?></td>
						<td><a target="_blank" href="/index/detail?user_id=<?php echo $item['user_id'];?>&type=<?php echo $type;?>"><?php echo $item["name"];?></a></td>
						<td><?php if($item["week_total"]==0){?><font color="red"><?php echo $item["week_total"];?></font><?php }else{ echo $item["week_total"];}?></td>
						<td><?php if($item["total_head"]==0){?><font color="red"><?php echo $item["total_head"];?></font><?php }else{ echo $item["total_head"];}?></td>
						<td><?php echo $item["total_head"]/1000 ?>%</td>
						<td><?php echo $item["guanxiu_total"]; ?></td>
	                </tr>
	           		 <?php }}?> 
                  </table>    
                </div>  
               <!-- end 表格 -->
              </div>
     </div>