//左侧导航
//tab标签切换
$(document).ready(function() { 
	$(".user_up").click(function(){
		var v = $(this).next().css('display');
		if(v=='block'){
			$(this).next().hide();
		}else{
			$(this).next().show();
		}
	});
}); 

	
//表单提示语
$(document).ready(function(){
    $("input:text, textarea, input:password").each(function(){
        if(this.value == '')
            this.value = this.title;
			$(this).css('color','#999');
    });
    $("input:text, textarea, input:password").focus(function(){
        if(this.value == this.title)
            this.value = '';
			$(this).css('color','#333');
			
    });
    $("input:text, textarea, input:password").blur(function(){
        if(this.value == ''){
            this.value = this.title;
			$(this).css('color','#999');}	
    });
});
