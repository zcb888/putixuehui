$(".hideinfo").hover(function(){
	$(this).find(".txt").stop().animate({height:"100%"},400);
	$(this).find(".txt h3").stop().animate({paddingTop:"20px"},400);
},function(){
	$(this).find(".txt").stop().animate({height:"45px"},400);
	$(this).find(".txt h3").stop().animate({paddingTop:"0px"},400);
})


$(function(){
       $(window).scroll(function(){
 		  //为页面添加页面滚动监听事件
		  var wst =  $(window).scrollTop(); //滚动条距离顶端值
		  if($('#jypx').offset().top<=wst+50){ //判断滚动条位置
			 $('.nva-yc a div').removeClass("navtop-in"); //清除c类
			 $('.nva-yc .jy').addClass("navtop-in");	//给当前导航加c类
		  }else{
			 $('.nva-yc a div').removeClass("navtop-in"); //清除c类 
			 $('.nva-yc .js').addClass("navtop-in"); 
		  };
		  
		  if($('#jjfa').offset().top<=wst+50){ //判断滚动条位置
			 $('.nva-yc a div').removeClass("navtop-in"); //清除c类
			 $('.nva-yc .jj').addClass("navtop-in");	//给当前导航加c类
		  }
		  
	  	});

	    $('.nva-yc a div').click(function(){
			$('.nva-yc a div').removeClass("navtop-in");
			$(this).addClass("navtop-in");
		});
});

$(function(){
	$(".zq").hover(function(){	
		$(this).find(".hide-yc").addClass("indyc");
	},function(){
		$(this).find(".hide-yc").removeClass("indyc");
	});
});