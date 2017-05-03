<script type="text/javascript">
    function search()
	{
		var name = $("#name").val();
		window.location= '/admin/menumodule/index?name='+name;
	}
</script>
<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>列表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/menumodule/add"); ?>" class="btn_blue">添加</a></div>
                  	<span>名称:</span><input type="text" id="name" name="name" value="<?php echo $name;?>" class="btn_txt"  />&nbsp;<input type="button" onclick="search();" class="btn-btn" value="搜索" />
               </div>
               <div class="col_tabs">   
                  <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
                    <tr class="tab_head">
	                   	<td>序号</td>
						<td>父类id</td>
						<td>名称</td>
						<td>标识</td>
						<td>url</td>
		                <td>操作</td>
	                </tr>
	                <?php if($list && count($list)>0){
	                foreach($list as $item){?>
	                <tr>
                 		<td><?php echo $item["id"];?></td>
						<td><?php echo $item["pid"];?></td>
						<td><?php echo $item["name"];?></td>
						<td><?php echo $item["flag"];?></td>
						<td><?php echo $item["url"];?></td>
	                    <td>
						<a href="<?php echo base_url(); ?>admin/menumodule/edit/<?php echo $item['id']; ?>"  title="修改"><i class="icon1_b"></i></a> &nbsp; &nbsp;
						<a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>admin/menumodule/del/<?php echo $item['id']; ?>';}" title="删除"><i class="icon2_b"></i></a>
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