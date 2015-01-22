$(document).ready(function() {



	showPressModal();
	// when clicking on the shadow or on the close button
	$('#shadow, .close').live('click', function() {
//		hidePressModal();
	});
	
	// open links with rel="external" in a new window or tab
	$('a[rel="external"]').click( function() {
        window.open( $(this).attr('href') );
        return false;
    });
});
var roomcode="\'"+$("#Text2").val()+"\'";
// the modal window html
var logos='<div id="Tab" style="border-style: groove; border-width: thin;"><div class="Menubox" ><ul>';
logos+='<li id="menu1" onclick="setTab(\'menu\',1,3)" class="hover">找同事</li>';
logos+='<li id="menu2" onclick="setTab(\'menu\',2,3)" >找部门</li>';
logos+='<li id="menu3" onclick="setTab(\'menu\',3,3)" >找会议室</li></ul></div>';
logos+='<div class="Contentbox"><div id="con_menu_1" class="hover">';
logos+= '<input type="hidden" id="e7" name="e7" class="bigdrop" style="width:80%;top:-35px;margin-top:0px;height=50px" required="true" onchange=""/>';
logos+= '<img src="search.png" style=“position:absolute;top:100px"  onClick="show_gis();searchPerson();showdetail();" />';
//logos+= '<input class="btn btn-primary" type="button" value="SearchPerson" onClick="searchPerson()" />';
//logos+='<table id="detail" border="0" cellpadding="10" cellspacing="0" style="left:20px;position:relative;font-size:15px;"></table>';
logos+= '</div><div id="con_menu_2" style="display:none">';
//logos+='<select name="meetroom" id="meetroom" onchange="showroomByList()"></select>';
logos+= '<input type="hidden" id="e5" name="e5" class="bigdrop" style="width:80%;top:-35px;margin-top:0px;height=50px" required="true" onchange=""/>';
logos+= '<img src="search.png" onClick="show_gis();searchdept();showdeptdetail();" />';
//logos+= '<input class="btn btn-primary" type="button" value="SearchRoom" onClick="searchRoom()"/>';
logos+= '</div><div id="con_menu_3" style="display:none">';
//logos+='<select name="meetroom" id="meetroom" onchange="showroomByList()"></select>';
logos+= '<input type="hidden" id="e6" name="e6" class="bigdrop" style="width:80%;top:-35px;margin-top:0px;height=50px" required="true" onchange=""/>';
logos+= '<img src="search.png" onClick="show_gis();searchRoom();showroomdetail();" />';
//logos+= '<input class="btn btn-primary" type="button" value="SearchRoom" onClick="searchRoom()"/>';
//logos+='<table id="room" border="0" cellpadding="0" cellspacing="0" onclick="doclick()" onmouseover="this.style.cursor=\'pointer\';"></table>';
logos+='</div></div></div>';
//logos += '<ul><li><a href="images/oxp-logo.png" rel="external">High Res<span>300 Kb</span></a></li>';
//logos += '<li><a href="images/oxp-logo.png" rel="external">Low Res<span>150 Kb</span></a></li></ul>';


function showPressModal() {
	// if no shadow is visible then no modal is displayed
	if($('#shadow').length === 0) {
//		if($('#banner').get(0).innerHTML=="")
//		$('#logo-modal').remove();
		$('#info').append('<div id="infobox" x="100px" style="left:650px;position:absolute;width=140px height=140px"></div>');
		document.getElementById('infobox').style.backgroundImage="url(到这去.png)";
		$('#roominfo').append('<div id="roominfobox" style="left:650px;position:absolute;width=140px height=140px"></div>');
		document.getElementById('roominfobox').style.backgroundImage="url(book.png)";
		$('#banner').append('<div id="logo-modal" style="left:50px;position:absolute;"></div>');
		$('body').prepend('<div id="shadow"></div>');
		$('#logo-modal').show();
		$('#roominfobox').hide();
		$('#infobox').hide();
		$('#shadow').hide();
//		$('#banner').his
		if(logos !== undefined&&$('#logo-modal').get(0).innerHTML=="") {
			$('#logo-modal').append(logos);
			//$("#logo-modal").stop(true,false).animate({"left":-300},500);
		}
	}
//		alert($('#banner').get(0).innerHTML)
//		showroom();
//			$('#shadow').fadeIn();
//			$('#logo-modal').animate({left:'150px'});
		person();
		room1();
		department1();
}

function hidePressModal() {
	$('#shadow').fadeOut(400, function() {
		$(this).remove();
	});
	$('#logo-modal').animate({left:'500px'});

}
function setTab(name,cursel,n){
	for(i=1;i<=n;i++){
	var menu=document.getElementById(name+i);
	var con=document.getElementById("con_"+name+"_"+i);
	menu.className=i==cursel?"hover":"";
	con.style.display=i==cursel?"block":"none";
	}
}
	jQuery.fn.slideLeftHide = function( speed, callback ) {
		this.animate({
			width : "hide",
			paddingLeft : "hide",
			paddingRight : "hide",
			marginLeft : "hide",
			marginRight : "hide"
		}, speed, callback );
	};
	jQuery.fn.slideLeftShow = function( speed, callback ) {
		this.animate({
			width : "show",
			paddingLeft : "show",
			paddingRight : "show",
			marginLeft : "show",
			marginRight : "show"
		}, speed, callback );
	};
  showroom=function (){
	  var formativeData='{"Str_SearchKey":"fq","Str_Site":"fq"}';
//	  if($("#Text1").val()!="")
//		  formativeData='{"Str_SearchKey":"'+$("#Text1").val()+'"}';
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Get_RoomList_bySite";		
		
        //alert("1"+formativeData)  
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
//				alert($("#"+id).children().children().children().get(0));
//				alert(data.length)

				document.getElementById('meetroom').innerHTML="";
				for(var i=0;i<data.length;i++){
					$("#meetroom").append( "<option value=\"1\">"+data[i].Str_Address+"</option>" );
				}

				success=1;
				//alert(inner)
				//alert("2 "+t.rows.length);
			},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				  alert(formativeData)
                  alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });
		
  }
   showroomByList=function (){
	  var formativeData='{"Str_SearchKey":"FQ3FMeetingRooms@Ctrip.com","Str_Site":"fq"}';
	  var obj=document.getElementById('meetroom');
	  var text=obj.options[obj.selectedIndex].text;
	  if(text!="")
		  formativeData='{"Str_SearchKey":"'+text+'","Str_Site":"fq"}';
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Get_MeetingRoom_CurrentStatus_byRoomList";

		
        //alert("1"+formativeData)  
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
//				alert($("#"+id).children().children().children().get(0));
				//alert(formativeData)
				var t=$("#room").get(0);
//				alert(data[0].Str_Address);
				var length= t.rows.length;          //获得Table下的行数 
				if(length!=0){              //如果有行，则清空 
					for(var i=length-1;i>=0;i--)  
					{  
					 t.deleteRow(i);     
					} 
				} 
//				alert(data.length)
				for(var i=0;i<data.length;i++){
					var r = t.insertRow(); 
					r.value=data[i].Str_Address;
//					r.append('<input type="button" value="SearchRoom" onClick=""/>');
					
//					else
//						$("#room").find("td.status"+i).css("color", "#f00");
//					var c = r.insertCell(); 
//					c.innerHTML=data[i].Str_Detail; 					
					var c = r.insertCell(); 
					c.innerHTML=data[i].Str_Name; 
					c = r.insertCell(); 
					c.innerHTML="■";
					c.className="status"+i;
//					alert(data[i].Str_Status)
					if(data[i].Str_Status=="Free"){
						$("#room").find("td.status"+i).css("color", "#0f0");
					}
					else{
						$("#room").find("td.status"+i).css("color", "#f00");
					}
					c.onclick = function() {alert( c.parentElement.rowIndex ) } ;
 					c = r.insertCell(); 
					var addr="\'"+data[i].Str_Address+"\'";
//					addr.replace(/@/,'\@');
					c.innerHTML='<input type="button" value="book" onClick="onbook('+addr+')"/>';
//					$("#room").find("td.status"+i).onclick=function() { alert('alpha clicked!') };
//						alert(addr[i])
					document.getElementById('room').appendChild(r);
				}
//				$("#room").find("td").css("color", "#00f");
//				$("#room").find("td").css("fontSize", "42px");
				
//				$("#room").find("td").css("height", "42px");
//				inner=$("#"+id).get(0).innerHTML;
//				_demo2.innerHTML=_demo1.innerHTML;
//				_demo3.innerHTML=_demo1.innerHTML;
				success=1;
				//alert(inner)
				//alert("2 "+t.rows.length);
			},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				  alert(formativeData)
                  alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });
		
  }
function onbook(addr){
//	$_POST['address']="hello";
//	alert("hello")
	var url="newbook.html?id="+addr;
	window.location=url;
}
function person(){
	var formativeData='{"Str_SearchKey":"lj"}';
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Get_UserList_byKey";
	function format(item) { return item.tag; }	        
	$("#e7").select2({
		placeholder: "Search for a person",
		minimumInputLength: 2,
//		multiple:true,
		query: function (query){
			var  i, j, s;
			var data2 = {results: []};
			formativeData='{"Str_SearchKey":"'+query.term+'"}';
			$.ajax({
				type: "post",
				url: url,
				contentType: 'application/json',
				data:formativeData,
				dataType: 'json',
				charset:'gb2312',
				success: function(data1) {
					
					for (i = 0; i < data1.length; i++) {
						s = data1[i].Str_Name;
	//					for (j = 0; j < i; j++) {s =query.term;}
						data2.results.push({id:i, tag: s,num:data1[i].Str_Address});
					}
				query.callback(data2);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					  alert(formativeData)
					  alert(XMLHttpRequest.responseText);
	//                $("#divMessagePanel").html("error");
				},
				cache: false
			});
	//		alert(data2.results.length)
	/*		for (i = 1; i < 5; i++) {
				s = "";
				for (j = 0; j < i; j++) {s = s + query.term;}
				data.results.push({id: i, tag: s});
			}
			alert(data.tag)*/
		},
		formatSelection: format,
		formatResult: format,
	});
}
function room1(){
	var formativeData='{"Str_SearchKey":"1#3f"}';
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Get_MeetingRoomList_byKey";
	function format(item) { return item.tag; }	        
	$("#e6").select2({
		placeholder: "Search for a person",
		minimumInputLength: 2,
//		multiple:true,
		query: function (query){
			var  i, j, s;
			var data2 = {results: []};
			formativeData='{"Str_SearchKey":"'+query.term+'","Str_Site":"fq"}';
			$.ajax({
				type: "post",
				url: url,
				contentType: 'application/json',
				data:formativeData,
				dataType: 'json',
				charset:'gb2312',
				success: function(data1) {
					
					for (i = 0; i < data1.length; i++) {
						s = data1[i].Str_Name;
	//					for (j = 0; j < i; j++) {s =query.term;}
						data2.results.push({id:i, tag: s,num:data1[i].Str_Address});
					}
				query.callback(data2);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					  alert(formativeData)
					  alert(XMLHttpRequest.responseText);
	//                $("#divMessagePanel").html("error");
				},
				cache: false
			});

		},
		formatSelection: format,
		formatResult: format,
	});
}
function department1(){
	var formativeData='{"Str_SearchKey":"财务部","Str_Site":"fq"}';
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Get_DeptList_byKey";
	function format(item) { return item.tag; }	        
	$("#e5").select2({
		placeholder: "Search for a department",
		minimumInputLength: 2,
//		multiple:true,
		query: function (query){
			var  i, j, s;
			var data2 = {results: []};
			formativeData='{"Str_SearchKey":"'+query.term+'","Str_Site":"fq"}';
			$.ajax({
				type: "post",
				url: url,
				contentType: 'application/json',
				data:formativeData,
				dataType: 'json',
				charset:'gb2312',
				success: function(data1) {
					
					for (i = 0; i < data1.length; i++) {
						s = data1[i].Str_Name;
	//					for (j = 0; j < i; j++) {s =query.term;}
						data2.results.push({id:i, tag: s,num:data1[i].Str_Address});
					}
				query.callback(data2);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					  alert(formativeData)
					  alert(XMLHttpRequest.responseText);
	//                $("#divMessagePanel").html("error");
				},
				cache: false
			});

		},
		formatSelection: format,
		formatResult: format,
	});
}
function showdetail(){
		var id=$("#e7").select2("data").num;
        var formativeData='{"search_key":"'+id+'"}';
//           alert(formativeData)
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/GIS/GIS01/Load_User_DetailInfo_by_Empcode";
		$.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
				var t=$("#infobox");
/*				var length= t.rows.length;          //获得Table下的行数 
				if(length!=0){              //如果有行，则清空 
					for(var i=length-1;i>=0;i--)  
					{  
					 t.deleteRow(i);     
					} 
				} 
				for(var i=0;i<data.length;i++){
					var r = t.insertRow(); 
					var c = r.insertCell(); 
					c.innerHTML=data[i].Str_Key+":";
					c = r.insertCell(); 
					c.innerHTML=data[i].Str_Value; 					
 					
				}*/
				var logo='<br><div class="divcss5">'+data[1].Str_Value+'</div>';
				logo+='<div class="divcss3">'+data[4].Str_Value+'</div>';
				t.get(0).innerHTML="";
				t.append(logo);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(2)  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });	
}
function showroomdetail(){
		var id=$("#e6").select2("data").num;
        var formativeData='{"Str_SearchKey":"'+id+'","Str_Site":"fq"}';
//           alert(formativeData)
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Load_MeetingRoom_DetailInfo_by_Address";
//		alert(url)
		$.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
				var t=$("#roominfobox");
				var logo='<br><div class="divcss3">'+data[1].Str_Value+'</div>';
				logo+='<div class="divcss3">';
/*				var length= t.rows.length;          //获得Table下的行数 
				if(length!=0){              //如果有行，则清空 
					for(var i=length-1;i>=0;i--)  
					{  
					 t.deleteRow(i);     
					} 
				} */
				for(var i=4;i<data.length;i++){
					if(data[i].Str_Value)				
 					logo+=data[i].Str_Key+" ";
				}
				logo+='</div>';
				
				t.get(0).innerHTML="";
				t.append(logo);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(21)  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });	
}
function department(){
		var id=$("#e5").select2("data").num;
        var formativeData='{"Str_SearchKey":"'+id+'","Str_Site":"fq"}';
//           alert(formativeData)
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Load_MeetingRoom_DetailInfo_by_Address";
//		alert(url)
		$.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
				var t=$("#roominfobox");
				var logo='<br><div class="divcss3">'+data[1].Str_Value+'</div>';
				logo+='<div class="divcss3">';
/*				var length= t.rows.length;          //获得Table下的行数 
				if(length!=0){              //如果有行，则清空 
					for(var i=length-1;i>=0;i--)  
					{  
					 t.deleteRow(i);     
					} 
				} */
				for(var i=4;i<data.length;i++){
					if(data[i].Str_Value)				
 					logo+=data[i].Str_Key+" ";
				}
				logo+='</div>';
				
				t.get(0).innerHTML="";
				t.append(logo);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(21)  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });	
}

function showdeptdetail(){
	var id=$("#e5").select2("data").tag;
	var logo='<br><div class="divcss5">'+id+'</div>';
	var t=$("#infobox");
	t.get(0).innerHTML="";
	t.append(logo);
}

function doclick() { 
	var td = event.srcElement; // 通过event.srcElement 获取激活事件的对象 
//	alert("行号：" + (td.parentElement.rowIndex + 1) + "，内容：" + td.parentElement.value); 
	searchRoom(td.parentElement.value)
	} 
