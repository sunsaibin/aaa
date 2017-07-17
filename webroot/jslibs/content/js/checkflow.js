/**
* @日期选择
*   请假申请 开始日期 askForLeave_staff_hand_startdate
*   请假申请 结束日期 ：askForLeave_staff_hand_enddate
*   入职申请 保底截止日期 ：entryAppli_staff_guaranteeddate
*   入职申请 员工生日 ：entryAppli_staff_birthday
*   入职申请 健康证有效期 ： entryAppli_staff_health_time
*   入职申请 入职日期 ：entryAppli_staff_change_date
*   入职申请 合同到期日 ：entryAppli_staff_contract_time
*   本店调动 新保底截止日期 ：storeTransfer_staff_guaranteeddate_new
*   本店调动 调动日期 ：storeTransfer_staff_change_date
*   跨店调动 新保底截止日期 ：crossStoreTransfer_staff_guaranteeddate_new
*   跨店调动 调动日期 ：crossStoreTransfer_staff_change_date
*   离职申请 原保底截止日期 ：departure_staff_guaranteeddate_old
*   离职申请 离职日期 ：departure_staff_change_date
*   重回公司 保底截止日期 ：backCompany_staff_guaranteeddate_new
*   重回公司 重回日期 ：backCompany_staff_change_date
*   重回公司 合同到期日 ：backCompany_staff_contractTime_new
*   薪资调整 原保底截止日期 ： salaryAdjustment_staff_guaranteeddate_old
*   薪资调整 新保底截止日期 ：salaryAdjustment_staff_guaranteeddate_new
*   薪资调整 调整日期 ：salaryAdjustment_staff_change_date
*   员工派遣 派遣日期 ：dispatch_staff_change_date
*   员工处罚 处罚日期 ：fine_staff_hand_date
 */
//var dataCalendar = "#askForLeave_staff_hand_startdate,#askForLeave_staff_hand_enddate,#entryAppli_staff_guaranteeddate,#entryAppli_staff_birthday,#entryAppli_staff_health_time,#entryAppli_staff_change_date,#entryAppli_staff_contract_time,"+
//"#storeTransfer_staff_guaranteeddate_new,#storeTransfer_staff_change_date,#crossStoreTransfer_staff_guaranteeddate_new,#crossStoreTransfer_staff_change_date,#departure_staff_guaranteeddate_old,#departure_staff_change_date,#backCompany_staff_guaranteeddate_new,#backCompany_staff_change_date,#backCompany_staff_contractTime_new,"+
//"#salaryAdjustment_staff_guaranteeddate_old,#salaryAdjustment_staff_guaranteeddate_new,#salaryAdjustment_staff_change_date,#dispatch_staff_change_date,#fine_staff_hand_date";
var dataCalendar = "#askForLeave_staff_hand_startdate,#askForLeave_staff_hand_enddate,#dmdate_entryAppli_staff_guaranteeddate,#dmdate_entryAppli_staff_birthday,#dmdate_entryAppli_staff_health_time,#dmdate_entryAppli_staff_change_date,#dmdate_entryAppli_staff_contract_time,"+
"#storeTransfer_staff_guaranteeddate_new,#storeTransfer_staff_change_date,#crossStoreTransfer_staff_guaranteeddate_new,#crossStoreTransfer_staff_change_date,#dmdate_departure_staff_guaranteeddate_old,#dmdate_departure_staff_change_date,#dmdate_backCompany_staff_guaranteeddate_new,#dmdate_backCompany_staff_change_date,#dmdate_backCompany_staff_contractTime_new,"+
"#dmdate_salaryAdjustment_staff_guaranteeddate_old,#dmdate_salaryAdjustment_staff_guaranteeddate_new,#dmdate_salaryAdjustment_staff_change_date,#dispatch_staff_change_date,#fine_staff_hand_date";
/*$(dataCalendar).calendar({
	onClose:function(){
		$("#askForLeave_staff_hand_startdate,#askForLeave_staff_hand_enddate").calendar("destroy");
	}
});*/
$(dataCalendar).calendar({
  multiple: false, // 多选
  value: new Date(),  //['2017-02-12']
  dateFormat: 'yyyy-mm-dd',  // 自定义格式的时候，不能通过 input 的value属性赋值 '2016年12月12日' 来定义初始值，这样会导致无法解析初始值而报错。只能通过js中设置 value 的形式来赋值，并且需要按标准形式赋值（yyyy-mm-dd 或者时间戳)
     
  onChange: function (p, values, displayValues) {
        //console.log(values, displayValues); // 值变化时要做的处理
   },
  onClose:function(){
    $("#askForLeave_staff_hand_startdate,#askForLeave_staff_hand_enddate").calendar("destroy");
  }
});

/**
 * @日期选择
 * 		开始时间 ：#startTime
 *   	结束时间 ：#endTime
 */
$("#startTime,#endTime").picker({
  title: "请选择时间",
  cols: [
    {
      values: (function () {
            var hours = [];
            for (var i=0; i < 24; i++) hours.push(i > 9 ? i : '0'+i);
            return hours;
          })()
    },
    {
    	values : ':'
    },
    {
      values: (function () {
            var minutes = [];
            for (var i=0; i<60; i++) minutes.push(i > 9 ? i : '0'+i);
            return minutes;
          })()
    }
  ]
});



/*
 * @选择性别
 */
$("#entryAppli_staff_gender").select({
  title: "选择性别",
  items: [{
      title: "男",
      value: "1",
    },
    {
      title: "女",
      value: "0",
    }]
});

/*
 * @请假类型
 */
$("#askForLeave_staff_hand_type").picker({
    title: "请选择请假类型",
    cols: [
        {
            textAlign: 'center',
            values: ['事假', '病假', '婚假', '丧假', '公休', '产假', '年假', '培训假', '学习假']
        }
    ]
});

/*
* @黑名单
 */
$("#departure_staff_blacklistflag").select({
  title: "选择加入黑名单",
  items: [{
      title: "是",
      value: "1",
    },
    {
      title: "否",
      value: "0",
    }]
});

/*
*@员工级别
 */
$(".staff_stafflevelname").select({
  title: '请选择员工级别',
  items: [{
    title: 'A级',
    value: '1',
  },
  {
    title: 'B级',
    value: '2'
  },
  {
    title: 'C级',
    value: '3'
  },
  {
    title: 'D级',
    value: '4'
  }]
});










