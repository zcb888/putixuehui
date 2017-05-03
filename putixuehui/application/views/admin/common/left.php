     <div class="leftpanel">
             <div class="users cb">
               <div class="fl"><img src="<?php echo base_url(); ?>style/img/me.png" width="60" height="60" /></div>
               <div class="frname">
                   <h1><?php echo $this->session->userdata ( 'loginname' );?></h1>
                   <h2><?php echo $this->session->userdata ( 'webname' );?></h2>
               </div>
             </div>
             <ul id="sub_1" class="usernav">
                <?php
				echo $this->static_admin->menuData();
				?>
             </ul>
             <div class="clearfix"></div>
     </div><!-- end 左侧 -->