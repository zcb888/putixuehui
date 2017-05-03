<script type="text/javascript">
    function search()
	{
		var course_type = $("#course_type").val();
		var year = $("#year").val();
		window.location= '/admin/grade/index?course_type='+course_type+'&year='+year;
	}
</script>
<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>届别列表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/grade/add"); ?>" class="btn_blue">添加</a></div>
                  	<span>课程类型:</span><select id="course_type" name="course_type" class="btn_select" /><option value="0">-全部-</option><option value="1" <?php if($course_type ==1) echo "selected = 'true'"; ?>>基础班</option><option value="2" <?php if($course_type ==2) echo "selected = 'true'"; ?>>加行班</option><option value="3" <?php if($course_type ==3) echo "selected = 'true'"; ?>>入行论</option><option value="4" <?php if($course_type ==4) echo "selected = 'true'"; ?>>净土班</option><option value="5" <?php if($course_type ==5) echo "selected = 'true'"; ?>>五论班</option><option value="6" <?php if($course_type ==6) echo "selected = 'true'"; ?>>研究班</option><option value="7" <?php if($course_type ==7) echo "selected = 'true'"; ?>>念佛堂</option></select><span>那一届:</span><select id="year" name="year" class="btn_select" /><option value="0">-全部-</option><option value="2000" <?php if($year ==2000) echo "selected = 'true'"; ?>>2000</option><option value="2001" <?php if($year ==2001) echo "selected = 'true'"; ?>>2001</option></select>&nbsp;<input type="button" onclick="search();" class="btn-btn" value="搜索" />
               </div>
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
	                   	<td>ID</td>
						<td>课程类型</td>
						<td>那一届</td>
						<td>介绍</td>
						<td>管理备注</td>
						<td></td>
		                <td>操作</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                foreach($list as $item){?>
	                <tr>
                 		<td><?php echo $item["id"];?></td>
						<td><?php echo $item["course_type"];?></td>
						<td><?php echo $item["year"];?></td>
						<td><?php echo $item["introduction"];?></td>
						<td><?php echo $item["remark"];?></td>
						<td><?php echo $item["add_time"];?></td> 
	                    <td>
						<a href="<?php echo base_url(); ?>admin/grade/edit/<?php echo $item['id']; ?>"  title="修改"><i class="icon1_b"></i></a> &nbsp; &nbsp;
						<a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>admin/grade/del/<?php echo $item['id']; ?>';}" title="删除"><i class="icon2_b"></i></a>
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