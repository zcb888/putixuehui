
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>学会报修系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="学会报修系统">
    <meta name="keywords" content="学会报修系统">
    <meta name="author" content="旺庆">
 	<link rel="shortcut icon" href="<?php echo base_url(); ?>style/img/fowang.ico" />
    <link href="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/css/bootstrap-responsive.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>
  <div style='margin:0 auto;display:none;'>
	<img src="<?php echo base_url(); ?>style/img/share.jpg" />
	</div>
    <div class="container">
    <form class="form-horizontal" method="post" action="/index/login">
    <fieldset>
      <div id="legend" class="">
        <legend class="">学会报修系统-登录</legend>
      </div>
    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">手机号码</label>
          <div class="controls">
            <input type="text" placeholder="请填写手机号码" name="phone" class="input-xlarge">
            <p class="help-block"></p>
          </div>
      </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">登录密码</label>
          <div class="controls">
            <input type="password" placeholder="请填写登录密码" name="password" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" type="submit">登 录</button>
          </div>
        </div>

    </fieldset>
  </form> 
	</div>
    <!-- /container -->
        <script src="http://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/bootstrap.min.js"></script>
      </body>
    </html>
