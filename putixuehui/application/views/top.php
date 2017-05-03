
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
    	<table class="table table-striped">
		 <tr><td>名次</td><td>姓名</td><td>磕头总数</td><td>文殊心咒</td><td>怀业祈祷文</td></tr>
		 <?php if($list && count($list)>0){
		 		$index = 0;
		 		foreach ($list as $item){
				$index++;
		 ?>
		  <tr><td><?php echo $index;?></td><td><a href="/index/detail?user_id=<?php echo $item['id'];?>"><?php echo $item['name'];?></a></td><td><?php echo $item['total_head'];?></td><td><?php echo $item['wenshu'];?></td><td><?php echo $item['huaiye'];?></td></tr>
		 <?php }}?>
		</table>
	</div>
    <!-- /container -->
        <script src="http://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/bootstrap.min.js"></script>
      </body>
    </html>
