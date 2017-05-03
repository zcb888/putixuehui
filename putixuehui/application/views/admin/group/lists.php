<div class="rightpanel">
         <div class="mian">
           <!-- 面包屑 -->
             <div class="map">
                <div class="cb"><h1>账号权限组</h1></div> 
             </div>
           <!-- end 面包屑 -->    
               <!-- 表格 -->
               <div class="tabform">
                   <div class="fr addbtn"><a href="<?php echo site_url("admin/groups/create"); ?>" class="btn_blue">添加权限组</a></div><br /><br />
               </div>
               <div class="col_tabs">  
        <table cellpadding="0" cellspacing="0" width="100%" class="tab_md" >
            <tr class="tab_head">
                 <td>编号</td>
                <td>组名</td>
                <td>描述</td>
                <td>站务权限</td>
            </tr>
            <?php
            if($lists && count($lists) >0){
             foreach($lists as $info){?>
            <tr>
				<td><?php echo $info['id']?></td>
                <td><?php echo $info['name']?></td>
                <td><?php echo $info['description']?></td>
                <td>
                 <a href="<?php echo site_url('admin/groups/edit/'.$info['id'])?>" title="修改"><i class="icon1_b"></i></a>
                <a href="<?php echo site_url('admin/groups/authority/'.$info['id'])?>">[设置]</a></td>
            </tr>
            <?php }}?>
        </table>
        </div>  
              </div><!-- end mian --> 
     </div><!-- end 右侧 -->