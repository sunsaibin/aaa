var baseUrl = "http://10.0.3.35:8089/venus/";
//var baseUrl = url.substring(0, url.indexOf("storesort"));
var server_api_get_url = "http://op.faxianbook.com/php/webroot/index.php/api_data/get_server_get_api/";
var server_api_user_url = "http://op.faxianbook.com/php/webroot/index.php/api_data/get_user_data_api/";
var treeUrl = baseUrl + "/web/housechangeorder/findsearchnode";
var childrentreeUrl = baseUrl + "/web/housechangeorder/findchildrennode";
var getUserUrl = baseUrl+"order/makeorder/getUser";
var user;//保存用户信息
var selectCompId=0;
var selectStoreId=0;
$(function() {
	 createTree();
});

var obj_tree_callback = null;
function set_tree_callback(fun){
	obj_tree_callback = fun;
}

function string_replace(str,str_old,str_new){
	var str2 = str.replace(str_old,str_new);
	if(str2 == str || str2.length == str.length) return str2;
	else{
		return string_replace(str2,str_old,str_new);
	}
}

function base_encode(str) {
	var str_dist = window.btoa(encodeURI(str));
	//console.log(str_dist);
	// var reg = new RegExp('/',"g");
	// var reg2 = new RegExp("+","g");
	// var reg3 = new RegExp('=',"g");
	str_dist = string_replace(str_dist, "/","_a"); // window.btoa(str);
	str_dist = string_replace(str_dist, "+","_b");
	str_dist = string_replace(str_dist, "=","_c");
	return str_dist;
}


/**
 * 获取初始化得数据，及所属公司的商品和所能操作的门店及公司
 */
function initData(userId,userStoreId,userCompId) {
	$.ajax({
		url : server_api_get_url+base_encode(treeUrl),
		data : {"userId" : userId},
		cache : false,
		async : false,
		type : "POST",
		dataType : 'json',
		success : function(result) {
			$('#modelTree').jstree({
				'core' : {
					  "animation" : 0,
					   "check_callback" : true,
					   'force_text' : true,
	                    "themes" : { "stripes" : true },
	                    "data": result.data.tree
				}
			}).bind('select_node.jstree', function(event, data) { // 绑定的点击事件
				//实时获取全树
	
		    	var ref = $('#modelTree').jstree(true);
		    	var parentNode=ref.get_selected();
				if(data.instance.is_leaf(data.node.id)==true)
		    	{
		    		var parentNodeid=ref.get_parent(parentNode);
		    		if(parentNodeid!="#" )
		    		{
		    			 selectCompId = parentNodeid.replace("com-", "");
		    			 selectStoreId=data.node.id.replace("STO-", "");
						 //$("#modelTreeAside,.tree-cover").hide();
						 if(obj_tree_callback != null){
						 	obj_tree_callback(1,selectCompId,selectStoreId);
						 }
		    		}
		    		else
		    		{
		    			selectCompId=userCompId;
		    			selectStoreId=userStoreId;

		    			if(obj_tree_callback != null){
						 	obj_tree_callback(2,selectCompId,selectStoreId);
						 }
		    		}

		    	}
		    	else
		    	{
		    		selectCompId=data.node.id.replace("com-", "");
		    		selectStoreId=0;
					$("#searchStoreId").val(data.node.text);
					$("#searchStoreId").data("idd",data.node.id);
					$("#modelTreeAside,.tree-cover").hide();

					if(obj_tree_callback != null){
					 	obj_tree_callback(3,selectCompId,selectStoreId);
					 }
		    	}	
				if(data.instance.is_leaf(data.node.id)==true)
		    	{
			
					var nodeId=data.node.id;
					var nodeType=0;
					$.ajax({
						url : server_api_get_url+base_encode(childrentreeUrl),
						data : {"nodeId" : nodeId,"nodeType":nodeType},
						cache : false,
						async : false,
						type : "GET",
						dataType : 'json',
						success : function(result) {
							if(result.data.childrenTrees!=null && result.data.childrenTrees.length>0)
							{
								 var sel={};
								for(var i=0;i<result.data.childrenTrees.length;i++)
								{
									var childrenNode= {state:'open',id : result.data.childrenTrees[i].id, text:  result.data.childrenTrees[i].text,date:result.data.childrenTrees[i].text,type:'default' };     
									sel=ref.create_node(parentNode,childrenNode,"last");
						            
								}
								ref.open_node(parentNode); 
							}
							else
								{
									$("#searchStoreId").val(data.node.text);
									$("#searchStoreId").data("idd",data.node.id);
									$("#modelTreeAside,.tree-cover").hide();
								}
						}
				});
		    	}
			});

			$("#searchStoreId").val(result.data.tree.text);
			$("#searchStoreId").data("idd",result.data.tree.id);
		}
	});
}




function showTree()
{
	$("#modelTreeAside,.tree-cover").show();

}

function createTree()
{
	var treeTemple ="<div class='tree-cover'></div>" +
			"<div class='model-tree-aside'  id='modelTreeAside' >"+
		"<div class='sear-tree-box'>"+
			"<input type='text' placeholder='请输入公司或部门编号' id='targetStoreId'>"+
			"<button><img src='../../jslibs/searchnode/content/images/search-icon.png'></button>"+
		"</div>"+
		"<div class='model-tree' id='modelTree'></div>"+"</div>";
	
	
	$("#close").click(function (){
		$("#modalbody").empty();
    });

	$(".nodeTreeBox").append(treeTemple);
	 $.post(server_api_user_url,  function(data) {
	 		user = data.user;
			initData(user.id,user.storeId,user.companyId);
			selectCompId=user.companyId;
			selectStoreId=user.storeId;

		 if(typeof(initDataByNodeId)=="function"){
			 	initDataByNodeId(selectCompId,selectStoreId);//回调方法，在页面加载时获取数据列表
		 }

		 }, "json");
}







