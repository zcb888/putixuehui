//首页提交孵化器
		function submitlike(id,count){
			var current = count+1; 
			$(".like-count").html(current);
				$.ajax( {
					url : '/message/likecount',
					data : {
						id : id
					},
					type : 'POST',
					success : function() {

					}
				});
			}