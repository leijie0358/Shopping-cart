$(document).ready(function() {




	// when clicking on the shadow or on the close button
	$('#shadow, .close').live('click', function() {
		hidePressModal();
	});
	
	// open links with rel="external" in a new window or tab
	$('a[rel="external"]').click( function() {
        window.open( $(this).attr('href') );
        return false;
    });
});
var roomcode="\'"+$("#Text2").val()+"\'";
// the modal window html
var logos='<div id="Tab"><div class="Menubox"><ul>';
logos+='<li id="menu1" onclick="setTab(\'menu\',1,2)" class="hover">员工</li>';
logos+='<li id="menu2" onclick="setTab(\'menu\',2,2)" >会议室</li></ul></div>';
logos+='<div class="Contentbox"><div id="con_menu_1" class="hover">';
logos+= '<input type="hidden" id="e7" name="e7" class="bigdrop" style="width:100%;" required="true" onchange="showdetail()"/>';
logos+= '<input class="btn btn-primary" type="button" value="SearchPerson" onClick="searchPerson()" />';
logos+='<table id="detail" border="0" cellpadding="10" cellspacing="0" style="left:20px;position:relative;font-size:15px;"></table>';
logos+= '</div><div id="con_menu_2" style="display:none">';
logos+='<select name="meetroom" id="meetroom" onchange="showroomByList()"></select>';
logos+= '<input id="Text2" size=15 type="text" />';
logos+= '<input class="btn btn-primary" type="button" value="SearchRoom" onClick="searchRoom()"/>';
logos+='<table id="room" border="0" cellpadding="0" cellspacing="0" onclick="doclick()" onmouseover="this.style.cursor=\'pointer\';"></table>';
logos+='</div></div></div>';
//logos += '<ul><li><a href="images/oxp-logo.png" rel="external">High Res<span>300 Kb</span></a></li>';
//logos += '<li><a href="images/oxp-logo.png" rel="external">Low Res<span>150 Kb</span></a></li></ul>';
	function Call()  {
		// check if right button is clicked
		 {
			showPressModal();
//			e.preventDefault();
		}
	}

function showPressModal() {
	// if no shadow is visible then no modal is displayed
	if($('#shadow').length === 0) {
//		if($('#banner').get(0).innerHTML=="")
//		$('#logo-modal').remove();
		$('#banner').append('<div id="logo-modal" style="left:500px;position:absolute;"></div>');
		$('body').prepend('<div id="shadow"></div>');
		$('#logo-modal').show();
		$('#shadow').hide();
		if(logos !== undefined&&$('#logo-modal').get(0).innerHTML=="") {
			$('#logo-modal').append(logos);
			//$("#logo-modal").stop(true,false).animate({"left":-300},500);
		}
	}
//		alert($('#banner').get(0).innerHTML)
		showroom();
			$('#shadow').fadeIn();
			$('#logo-modal').animate({left:'150px'});
		person();
		
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
				var t=$("#detail").get(0);
				var length= t.rows.length;          //获得Table下的行数 
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
 					
				}
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(2)  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });	
}
function doclick() { 
	var td = event.srcElement; // 通过event.srcElement 获取激活事件的对象 
//	alert("行号：" + (td.parentElement.rowIndex + 1) + "，内容：" + td.parentElement.value); 
	searchRoom(td.parentElement.value)
	} 