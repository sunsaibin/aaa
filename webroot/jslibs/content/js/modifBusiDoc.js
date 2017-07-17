//订单类型选项卡tab切换
$("#mobudocLeftContent dl dd").click(function(){
	var theNum = $(this).data("num");
	$(this).addClass("active").siblings().removeClass("active");
	$("#mobudocRight>div[data-num="+ theNum +"]").addClass("active").siblings().removeClass("active");
});
