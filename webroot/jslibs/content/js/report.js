$(function(){
  var report = $(".report").width();
  $(window).resize(function(){
    var report = $(".report").width();
  });
  var td_width = report/13;
  var table_length = $(".table-report1 table tr:first-child td:visible").length;
  $(".table-report1 table").width(td_width * table_length);
  $(".table-report1 table td").width(td_width);

  function changeTable(){
    var table_length = $(".table-report1 table tr:first-child td:visible").length;
    $(".table-report1 table").width(td_width * table_length);
    $(".table-report1 table td").width(td_width);
  }

  //打开表格列组
  $("tr:first-child .tdGroup").click(function(){
    //
    var row = $(this).index();
    var next_row = $(this).nextAll(".tdGroup").index();
    if(next_row == -1){
      next_row = $("tr:first-child .tdSub:last").index() + 1;
    }
      var rowLength = next_row - row -1;
      for(var i = 0; i <= rowLength; i++){
        row = row + 1;
        var nth = "td:nth-child(" + row +")";
        $(nth).removeClass("tdSub").addClass("tdOpenBg");
      }
    $(this).addClass("tdOpenBg").removeClass("tdGroupOpen");
    changeTable();
  });

  //关闭表格列组
  $("tr:first-child .rowBg").click(function(){
    var prev_row = $(this).prevAll(".tdGroup").index();
    var this_index = $(this).index();
    var rowLength = this_index - prev_row;
    var row = prev_row + 1;

    for(var i = 0; i < rowLength; i++){
      row = row + 1;
      var nth = "td:nth-child(" + row +")";
      $(nth).removeClass("tdOpenBg").addClass("tdSub");
    }
    var tdORow = " td:nth-child(" +(row - rowLength) +")";
    var tdORowFirst = "tr:first-child" + " td:nth-child(" +(row - rowLength) +")";
    $(tdORow).removeClass("tdOpenBg");
    $(tdORowFirst).addClass("tdGroupOpen");
    changeTable();
  });

});