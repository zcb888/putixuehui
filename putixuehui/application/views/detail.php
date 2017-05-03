
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $model->name; ?>统计结果</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $model->name; ?>统计">
    <meta name="keywords" content="<?php echo $model->name; ?>统计">
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
        <legend class=""><?php echo $model->name; ?>统计,磕头总数:<?php echo $model->total_head;?>&nbsp;<a href="/">[首页]</a></legend>
      </div>
    	<table class="table table-striped">
		 <tr><td>日期</td><td>大头</td><td>文殊</td><td>怀业</td><td>观修</td></tr>
		 <?php if($list && count($list)>0){
		 		$index = 0;
		 		foreach ($list as $item){
				$index++;
		 ?>
		  <tr><td><?php echo $item['action_date'];?></td><td><?php echo $item['big_head'];?></td><td><?php echo $item['wenshu'];?></td><td><?php echo $item['huaiye'];?></td><td><?php echo $item['guanxiu'];?></td></tr>
		 <?php }}?>
		</table>
		 <div class="pages">
                     <?php echo $pagination; ?>
         </div>
	</div>
    <!-- /container -->
        <script src="http://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/bootstrap.min.js"></script>
      </body>
    </html>
