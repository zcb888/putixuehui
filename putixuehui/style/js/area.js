function getRegionList(param)
{   

	jqObj = param;
	send = jqObj.attr("value");

	// 输入为空时清除后面的列表。
	if(send=='' || send==undefined || send==null)
	{
		jqObj.nextAll().html('<option value="">--请选择地区--</option>');
		$('.shipping_tips').text('是否支持配送');

		 return false;
	}

	$.get("/other/tregion/AjaxGetRegionList/"+send,function (data, textStatus){
		selectHtml = '<option value="">--请选择地区--</option>';
		//data = eval("(" + data + ")");
	   
		// alert(typeof data);

		for(var key in data)
		{
			selectHtml += '<option value="'+key+'">'+data[key]+'</option>';
		}
		jqObj.nextAll().html('<option value="">--请选择地区--</option>');
		jqObj.next('select').html(selectHtml);
	}, "json");
}

$('.address').change(function(){
	// alert('getRegionList');
	getRegionList($(this));
});