<script type="text/javascript">
    function search()
	{
		var name = $("#txtname").val();
		var username = $("#txtusername").val();
		window.location= '/admin/groups/adminlist?name='+name+"&username="+username;
	}
</script>
<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>管理员列表</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/groups/adminadd"); ?>" class="btn_blue">添加管理员</a></div>
                  <span>姓名:</span><input type="text" id="txtname" name="name" value="<?php echo $name;?>" class="btn_txt"  />
                  <span>用户名:</span><input type="text" id="txtusername" name="username" value="<?php echo $username;?>" class="btn_txt"  />
                  &nbsp;&nbsp;<input type="button" onclick="search();" class="btn-btn" value="搜索" />&nbsp;&nbsp;
               </div>
               <div class="col_tabs">  
        <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
            <tr class="tab_head">
                <td>编号</td>
                <td>用户名</td>
                <td>姓名</td>
                <td>权限</td>
                <td>添加时间</td>
                <td>操作</td>
            </tr>
            <?php foreach($list as $info):?>
            <tr>
                <td><?php echo $info['id']?></td>
                <td><?php echo $info['username']?></td>
                <td><?php echo $info['name']?></td>
                <td><?php echo $info['groups']?></td>
                <td><?php echo $info['regtime']?></td>
                <td>
                <a href="<?php echo base_url(); ?>admin/groups/adminedit/<?php echo $info['id']; ?>" title="修改"><i class="icon1_b"></i></a>
                <?php if($info['username']=="admin") { echo '不可删除'; } else {?>
                    <a href="javascript:if(confirm('你确定要删除吗？')){ window.location.href='<?php echo base_url(); ?>admin/groups/deladmin?id=<?php echo $info['id']; ?>';}" title="删除"><i class="icon2_b"></i></a>
                    <?php }?></td>
            </tr>
            <?php endforeach;?>
        </table>
        </div>  
               <!-- end 表格 -->
                <!-- 翻页 -->
                 <div class="pages">
                     <?php echo $pagination; ?>
                 </div>
               <!-- end 翻页 -->
              </div><!-- end mian --> 
     </div><!-- end 右侧 -->