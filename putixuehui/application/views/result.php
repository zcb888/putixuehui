
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $group_name?>统计结果</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="报修系统统计结果">
    <meta name="keywords" content="报修系统统计结果">
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
        <legend class=""><?php echo $date; ?>统计<?php if($date == date('Y-m-d')) {?><a href="/index/result?date=<?php echo date("Y-m-d",strtotime("-1 day"));?>">[查看昨天]</a><?php }else{ ?><a href="/index/result">[查看今天]</a><?php }?>&nbsp;<a href="/">[首页]</a></legend>
      </div>
    	<table class="table table-striped">
		 <tr><td>序号</td><td>姓名</td><td>大头</td><td>文殊心咒</td><td>怀业祈祷文</td></tr>
		 <?php if($action_list && count($action_list)>0){
		 		$index = 0;
		 		foreach ($action_list as $item){
				$index++;
		 ?>
		  <tr><td><?php echo $index;?></td><td><a href="/index/detail?user_id=<?php echo $item['user_id'];?>"><?php echo $item['name'];?></a></td><td><?php echo $item['big_head'];?></td><td><?php echo $item['wenshu'];?></td><td><?php echo $item['huaiye'];?></td></tr>
		 <?php }}?>
		</table>
		<div><?php if($date == date('Y-m-d') && date('H')>19) echo '以下师兄，请抓紧时间报修量:<br />'.$unsubmit_name;else if($date< date('Y-m-d') ) echo $date.'日有以下师兄尚未报修量:<br />'.$unsubmit_name;?></div>
	</div>
    <!-- /container -->
        <script src="http://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/twitter-bootstrap/2.0.4/bootstrap.min.js"></script>
      </body>
    </html>
