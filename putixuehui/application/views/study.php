
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $group_name?>排行榜</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="报修系统统计排行榜">
    <meta name="keywords" content="报修系统统计排行榜">
    <meta name="author" content="旺庆">
 	<link rel="shortcut icon" href="<?php echo base_url(); ?>style/img/fowang.ico" />
    <link href="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/css/bootstrap.min.css" rel="stylesheet">

    <link href="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/css/bootstrap-responsive.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>
    <div class="container">
    <div id="legend" class="">
        <legend class=""><?php echo $group_name?>磕大头排行榜&nbsp;<a href="/">[首页]</a></legend>
      </div>
      <form class="form-horizontal" method="post" action="/study/save">
    	<table class="table table-striped">
		 <tr><td>序号</td><td>姓名</td><td>传承</td></tr>
		 <?php if($list && count($list)>0){
		 		$index = 0;
		 		foreach ($list as $item){
				$index++;
		 ?>
		  <tr><td><?php echo $index;?></td><td><a href="/index/detail?user_id=<?php echo $item['id'];?>"><b><?php echo $item['name'];?></b></a></td><td><input type="checkbox" name="chuancheng[]" checked="checked" value="<?php echo $item['id'];?>">圆满</td>

		  </tr>
		  <tr><td>共修情况</td><td colspan="2"><input type="radio" name="join_state_<?php echo $item['id'];?>" checked="checked" value="1" />正常&nbsp;<input type="radio" name="join_state_<?php echo $item['id'];?>" value="2" />迟到&nbsp;<input type="radio" name="join_state_<?php echo $item['id'];?>" value="3" />早退&nbsp;<input type="radio" name="join_state_<?php echo $item['id'];?>" value="4" />事假&nbsp;<input type="radio" name="join_state_<?php echo $item['id'];?>" value="5" />病假&nbsp;</td></tr>
		 <?php }}?>
		</table>
		 <div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
           <input type="hidden" value="<?php echo $user_id;?>" name="user_id" >
            <input type="hidden" value="<?php echo $chapter_id;?>" name="chapter_id" >
            <button class="btn btn-success" type="submit" name="save">提 交</button>
          </div>
        </div>
        </form>
	</div>
    <!-- /container -->
        <script src="http://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/bootstrap.min.js"></script>
      </body>
    </html>
