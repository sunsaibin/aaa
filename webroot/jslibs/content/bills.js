$(function(){

	/*
	 * 单击单号(如：601420160905006)，显示单号详情
	 */
	$(".orderno").click(function(){
		$("#billsOrderset").show();
	});
	
	/*
	 * 单击选择，如(收银（100）、积分消费（0）、充值（0）、反充（0）)的当前状态
	 */
	$(".bill-item-class li").click(function(){
		$(this).addClass("active").siblings("li").removeClass("active");
		$("#billsOrderset").hide();
	});

	//修改单据
	$("#billsModifyOrder").click(function(){
		$("#billsOrderset select,#billsOrderset input").attr("disabled",false);
	});

	//保存修改
	$("#billSaveOrder").click(function(){
		$("#billsOrderset select,#billsOrderset input").attr("disabled",true);
	});

	/*
	 *单据分析 操作
	 */
	$("#btnAnalysis").click(function(){
		$("#btnSettle").removeClass("disabled");
		$("#sealDayAnalysis").slideDown();
		//$("#sealDayAnalysis").show();
	});
});