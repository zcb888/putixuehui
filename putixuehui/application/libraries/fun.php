<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class CI_Fun {
    function __construct()
    {
    	$this->CI =& get_instance();
    }
    /*
     * 判断是否为移动设备
     * 
     */
    function isMobile()
    {
    	// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    	if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    	{
    		return true;
    	}
    	// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    	if (isset ($_SERVER['HTTP_VIA']))
    	{
    		// 找不到为flase,否则为true
    		return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    	}
    	// 脑残法，判断手机发送的客户端标志,兼容性有待提高
    	if (isset ($_SERVER['HTTP_USER_AGENT']))
    	{
    		$clientkeywords = array ('nokia',
    				'sony',
    				'ericsson',
    				'mot',
    				'samsung',
    				'htc',
    				'sgh',
    				'lg',
    				'sharp',
    				'sie-',
    				'philips',
    				'panasonic',
    				'alcatel',
    				'lenovo',
    				'iphone',
    				'ipod',
    				'blackberry',
    				'meizu',
    				'android',
    				'netfront',
    				'symbian',
    				'ucweb',
    				'windowsce',
    				'palm',
    				'operamini',
    				'operamobi',
    				'openwave',
    				'nexusone',
    				'cldc',
    				'midp',
    				'wap',
    				'mobile'
    		);
    		// 从HTTP_USER_AGENT中查找手机浏览器的关键字
    		if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
    		{
    			return true;
    		}
    	}
    	// 协议法，因为有可能不准确，放到最后判断
    	if (isset ($_SERVER['HTTP_ACCEPT']))
    	{
    		// 如果只支持wml并且不支持html那一定是移动设备
    		// 如果支持wml和html但是wml在html之前则是移动设备
    		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
    		{
    			return true;
    		}
    	}
    	return false;
    }
    
    /*
     * 获取伪静态页面的参数值
     */
    function get_url_par($page_url){
    	$temp_str= substr($page_url,strpos($page_url, '_')+1,(strlen($page_url)-strpos($page_url, '.html')-2));
    	$par_array = explode('_', $temp_str);
    	return $par_array;
    }
    
	/*
	 * 分页
	 * @return array
	 */
	public function page($url, $count, $per, $uri, $num){
		if(isset($_GET['per_page'])){
			$page = $_GET['per_page'];
		} else {
			$page = 1;
		}
		$config['base_url'] = $url;
		$config['total_rows'] = $count;
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = $per;//每页多少条
		$config['first_url'] = $uri;
		$config['num_links'] = $num;
		$config['full_tag_open'] = '<div class="fl allpage">共<span>'.ceil($count/$per).'</span>页,&nbsp;当前第<span>'.$page.'</span>页</div><div class="pagination fr"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = '第一页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '最末页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '下一页';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '上一页';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="up"><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['anchor_class'] = '';
		
		
		
		
		
		return $config;
	}
	

	/*
	 * 分页
	* @return array
	*/
	public function web_page($url, $count, $per, $num){
		if(isset($_GET['per_page'])){
			$page = $_GET['per_page'];
		} else {
			$page = 1;
		}
		$config['base_url'] = $url;
		$config['total_rows'] = $count;
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = $per;//每页多少条
		$config['first_url'] = $url.'/1';
		$config['num_links'] = $num;
		$config['full_tag_open'] = '<dl><dt class="center"><ul>';
		$config['full_tag_close'] = '</ul></dt></dl>';
		$config['first_link'] = '<<';
		$config['first_tag_open'] = '<li id="left"><a>';
		$config['first_tag_close'] = '</a></li>';
		$config['last_link'] = '>>';
		$config['last_tag_open'] = '<li id="right"><a>';
		$config['last_tag_close'] = '</a></li>';
		$config['next_link'] = '>';
		$config['next_tag_open'] = '<li><a>';
		$config['next_tag_close'] = '</a></li>';
		$config['prev_link'] = '<';
		$config['prev_tag_open'] = '<li><a>';
		$config['prev_tag_close'] = '</a></li>';
		$config['cur_tag_open'] = '<li><a id="a-line">';
		$config['cur_tag_close'] = '</a></li>';
		$config['anchor_class'] = '';
		return $config;
	}
	
	/*
	 * 得到一段时间内要用到的表前缀
	 * @return array
	 */
	public function gettimearr($rtstarttime,$rtendtime){
		$rtstartyear=date("Y",$rtstarttime);
		$rtstartmonth=date("m",$rtstarttime);
		$rtendyear=date("Y",$rtendtime);
		$year=$rtendyear-$rtstartyear;
		$rtmonth=date("m",$rtendtime);
		$nowmonth="";
		for($i=0,$startyear=$rtstartyear;$i<=$year;$i++){
			$nowyear=$startyear+$i;
			if($nowyear==$rtstartyear){
				if($year==0){
					for($j=0,$startmonth=$rtstartmonth;$nowmonth<intval($rtmonth);$j++){
						$nowmonth=$startmonth+$j;
						$nowmonth=sprintf("%02d", $nowmonth);
						$time[]=$nowyear.$nowmonth;
					}}else{
						for($j=0,$startmonth=$rtstartmonth;$nowmonth<12;$j++){
							$nowmonth=$startmonth+$j;
							$nowmonth=sprintf("%02d", $nowmonth);
							$time[]=$nowyear.$nowmonth;
						}
					}
			}else if($nowyear!=$rtendyear){
				for($j=1;$j<13;$j++){
					$nowmonth=sprintf("%02d", $j);
					$time[]=$nowyear.$nowmonth;
				}
			}else{
				for($j=1;$j<=$rtmonth;$j++){
					$nowmonth=sprintf("%02d", $j);
					$time[]=$nowyear.$nowmonth;
				}
			}
				
		}
		return $time;
	}
	
    //调用接口公用
	public function curl_post($url, $post) {
	    $options = array(  
	        CURLOPT_RETURNTRANSFER => true,  
	        CURLOPT_HEADER         => false,  
	        CURLOPT_POST           => true,  
	        CURLOPT_POSTFIELDS     => $post,  
	    );   
   
    
	    $ch = curl_init($url);  
	    curl_setopt_array($ch, $options);  
	    $result = curl_exec($ch);  
	    curl_close($ch); 
	     
	    return $result;  
	}
}
