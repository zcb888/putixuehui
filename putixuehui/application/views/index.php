
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $group_name;?>报修系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="养育巷2016届报修系统">
    <meta name="keywords" content="养育巷2016届报修系统">
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
    <form class="form-horizontal" method="post" action="/index/result">
    <fieldset>
      <div id="legend" class="">
        <legend class=""><?php echo $group_name;?>报修系统&nbsp;<a href="/index/result">[查看结果]</a></legend>
      </div>
    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">日期:</label>
          <div class="controls">
            <input type="text" placeholder="" name="action_date" value="<?php echo date('Y-m-d')?>" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label">姓名:</label>
          <div class="controls">
      <!-- Inline Radios -->
     
      <label class="radio inline">
        <input type="hidden" value="<?php echo $user_id;?>" name="user_id" >
        <?php echo $name;?>&nbsp;&nbsp;&nbsp;<a href="/index/logout">[退出]</a>&nbsp;&nbsp;<a href="/index/changepwd">[修改密码]</a>&nbsp;&nbsp;<a href="/index/top">[排行榜]</a>
      </label>
  		</div>
     </div>
     
    	<div class="control-group">
          <label class="control-label" for="input01">磕大头数量:</label>
          <div class="controls">
            <input type="text" placeholder="请填写数字" name="big_head" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>
    	<div class="control-group">
          <label class="control-label" for="input01">文殊心咒数量:</label>
          <div class="controls">
            <input type="text" placeholder="请填写数字" name="wenshu" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="input01">怀业祈祷文:</label>
          <div class="controls">
            <input type="text" placeholder="请填写数字" name="huaiye" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="input01">观修:</label>
          <div class="controls">
            <input type="text" placeholder="请填写数字" name="guanxiu" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>
    <!--<div class="control-group">

         
          <label class="control-label" for="input01">磕小头数量:</label>
          <div class="controls">
            <input type="text" placeholder="请填写数字" name="small_head" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label">其它备注:</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" name="remark" class=""> </textarea>
            </div>
          </div>
        </div>-->
        
        <div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" type="submit">提 交</button>
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
