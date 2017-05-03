<style>
.content_wrap h4{ padding:20px 0 0 0; color:#666; font-weight:normal;}
.ztree li{ float:left; padding:10px; border:1px solid #ddd; margin:20px 20px 0 0;}
.ztree li a.checkbox-group label{ font-weight:bold; font-size:14px;}
.btn-group{ clear:both; overflow:hidden; margin-top:30px; padding:20px; border-top:1px dashed #ddd;}
.btn-save{ width:140px;}
</style>
<div class="rightpanel">
    <div class="mian"> 
        <!-- 面包屑 -->
        <div class="map">
            <div class="cb">
                <h1>账号管理</h1>
            </div>
        </div>
       	<div id="container" class="public_w">
        <div class="content_wrap">
            <h4>请选择该权限组下面可使用的模块：</h4>
            <form action="<?php echo site_url('admin/groups/postAuthority');?>" method="post">
            <input name="gid" value="<?php echo $gid; ?>" type="text" hidden="hidden" />
                            <ul id="treeDeta" class="ztree">
                            	<?php   foreach ($list as $key => $item){ ?>
                                <li class="m-li f-cb">
                                    <span class="btn-addOrminus btn-minus"></span>
                                    <a class="checkbox-group">
                                        <input type="checkbox" id="checkbox1" class="checkbox-control g" value="<?php echo $item['id']; ?>" name="item[]" <?php if(isset($item['selected'])){if($item['selected']==1){ echo 'checked="checked"'; }} ?> g="1" />
                                        <label for="checkbox1"><?php echo $item['name']; ?></label>
                                    </a>
                                    <ul class="m-ul ul-line">
                                    	<?php 
                                    	$sublist = $item['list'];
                                    	if($sublist && count($sublist)) {
                                    	foreach ($sublist as $subitem){ ?>
                                        <li>
                                            <span class="icon-line"></span>
                                            <span class="checkbox-group">
                                                <input type="checkbox" id="checkbox1-1" class="checkbox-control" value="<?php echo $subitem['id']; ?>" name="item[]" g="1" <?php if(isset($subitem['selected'])){if($subitem['selected']==1){ echo 'checked="checked"'; }} ?>  />
                                                <label for="checkbox1-1"><?php echo $subitem['name']; ?></label>
                                            </span>
                                        </li>
                                        <?php } }?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                <div class="clearfix"></div>
                <div class="btn-group">
                    <button type="submit" class="btn_blue btn-save">&nbsp;&nbsp;保存&nbsp;&nbsp;</button>
                    <a href="/admin/groups/lists">
                    <button type="button" class="btn_gray btn-black">&nbsp;&nbsp;返回&nbsp;&nbsp;</button>
                    </a> </div>
            </form>
        </div>
<script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
     $(document).ready(function(){
        $("span.btn-addOrminus").click(function(event){
          $(event.target).closest("li.m-li").find("ul.m-ul").toggle();
          if ($(event.target).hasClass('btn-minus')) {
            $(event.target).removeClass('btn-minus').addClass('btn-add');
          } else {
            $(event.target).removeClass('btn-add').addClass('btn-minus');
          }
        });
        $("input.g").click(function(event){
          $(event.target).closest("li.m-li").find("input:checkbox").each(function(){
            this.checked = event.target.checked;
          });
        });
    });
</script>
        </div>
    </div>
    <!-- end mian --> 
</div>
<!-- end 右侧 -->