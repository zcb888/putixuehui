<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>style/css/login.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-1.7.min.js"></script>
	<script type="text/javascript">
// ---zitian


$(function(){
	var login_width=document.documentElement.clientWidth;
  	var login_height=document.documentElement.clientHeight;
	$("#container").css({width:login_width,height:login_height});
		
	})
function getFocus(){
	$(this).focus(function(){
		$(this).parent().css("background-color","#ff0")
		})
	}
getFocus("#username");
</script>
	<script type="text/javascript">
      $(document).ready(function(){
          var docH=$(window).height();

          var topH=( $(".header-top").height());
          var contH=($("#login").height());
          <!--  var topP=($(".header-top").padding-top());-->
          $(".page").css({"height":docH-topH+"px"});
          $(".content").css({"margin-top":(docH-contH)/2+"px"});

      });
 //  </script>
	<title>后台登录</title>
</head>
<body>
	<div class="page">
		<div class="middle">
			<div class="content ">

				<div id="container" >
					<div id="login">
						<div class="title">
							<div class="content-fst">
								<span class="fl"></span>
								<h2 class="fl">登录</h2>
								<p class="fl">请输入您的后台登陆帐号</p>
							</div>
						</div>
						<div class="content-snd">
							<form action="<?php echo site_url('admin/login'); ?>
								" method="post"  target="tarframe">
								<div class="login_con">
									<p>
										<a class="userName">
											<input type="text" id="username" name="user" /></a>
									</p>
								
									<p>
										<a class="psw">
											<input type="password" id="psw" name="pass"/>
										</a>
									</p>
									<!-- <p class="authCode">
										<label  class="fl"style="">验证码：</label>
										<input  class="fl" type="text" style="" id="captcha" name="captcha"/>
										<a class="authCode_img fl" onclick="document.getElementById('captchaimage').src='<?php echo base_url(); ?>
											index.php/admin/captcha/index?'+Math.random();
    document.getElementById('captcha').focus();" >
											<img id="captchaimage" src="<?php echo site_url('admin/captcha/index');?>" /></a>
										<span class="kbq" onclick="document.getElementById('captchaimage').src='<?php echo base_url(); ?>
											index.php/admin/captcha/index?'+Math.random();
    document.getElementById('captcha').focus();">看不清
										</span>
									</p> -->
									<p>
										<span>
											<input class="login_btn" type="submit" value="登&nbsp&nbsp录" />
										</span>
									</p>

								</div>
							</form>
						</div>
						<div class="content_third">
							<p>技术支持：苏.旺庆(微信号：zhangcb21)</p>
						</div>
						<iframe src=""  width="500px" height="500px"   style="display:none;" name="tarframe" ></iframe>
					</div>
				</div>

			</div>
		</div>
	</div>

</body>
</html>