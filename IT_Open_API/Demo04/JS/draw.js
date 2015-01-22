

function drawMark(divid,coordinateX,coordinateY){  //绘制接口 传入层id，两个坐标
	
				document.getElementById(divid).style.display=""; 

				//document.getElementById('message').innerHTML=""; 
				//document.getElementById('gothere').innerHTML=""; 


				var divObj=document.getElementById(divid);
				divObj.style.position='absolute';
				divObj.style.left = coordinateX+ "px";
				divObj.style.top=coordinateY+"px";								
				
				}
				
				
				
				
function searchPerson() {  //搜索员工坐标
		//var id="s26618";////////////////////////////////////////////
		var id=choosedPerson;
		var url=location.href;
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/GIS/GIS01/Search_Entity_POS";
		
        var formativeData='{"Str_Site":"fq","search_key":"'+id+'"}';
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
            	
         /////////////////////////////////   	
        var location1=data[0].Str_Return;	//目标位置各顶点坐标
        var str=new Array();        
        if(location1!="")
        str=location1.split('|');
       // alert(location1);
       // alert(str);
        var str1=new Array();
        str1=str[0].split(',');
				//alert(str1);
		
		drawMark( "infobox" ,str1[0],str1[1]);
		
	/*	
		url=location.href;
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/GIS/GIS01/Navigation_ByPos";
		var s_pos_x=740,s_pos_y=400;
        var str1=new Array();
        str1=str[0].split(',');
        formativeData = '{"Str_Site":"fq","d_pos_x":"'+str1[0]+'","d_pos_y":"'+str1[1]+'","s_pos_x":"'+s_pos_x+'","s_pos_y":"'+s_pos_y+'"}';

        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {


                nav[currentImage]=data.Str_Return;
				
                mark_pos[currentImage]=s_pos_x+","+s_pos_y+"|"+str1[0]+","+str1[1];
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(1)  ;
                    alert(XMLHttpRequest.responseText);
            },
            cache: false
        });             

*/
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(2+"person")  ;
                    alert(XMLHttpRequest.responseText);
            },
            cache: false
        });


    }
    
    

function searchDept() {//搜索部门坐标
     
        //var id ="DEPT0009";
				var id=choosedDept;

        var url = location.href;
        url = url.substring(0, url.lastIndexOf("/"));
        url = url.substring(0, url.lastIndexOf("/"));
        url += "/GIS/GIS01/Search_Entity_POS";
        var formativeData = '{"Str_Site":"fq","search_key":"' + id + '"}';
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data: formativeData,
            dataType: 'json',
            success: function (data) {

                location1= data[0].Str_Return; //目标位置各顶点坐标


               
                var str = new Array();
                if (location1!= "")
                    str = location1.split('|'); //alert(location1[currentImage])
                    
        var location1=data[0].Str_Return;	//目标位置各顶点坐标
        var str=new Array();        
        if(location1!="")
        str=location1.split('|');
       // alert(location1);
       // alert(str);
        var str1=new Array();
        str1=str[0].split(',');
				//alert(str1);
				drawMark( "infobox" ,str1[0],str1[1]);
                 
                 /*
                    
                url = location.href;
                url = url.substring(0, url.lastIndexOf("/"));
                url = url.substring(0, url.lastIndexOf("/"));
                url += "/GIS/GIS01/Navigation_ByPos";
                var s_pos_x = 740, s_pos_y = 400;
                var str1 = new Array();
                str1 = str[0].split(',');
                formativeData = '{"Str_Site":"fq","d_pos_x":"' + str1[0] + '","d_pos_y":"' + str1[1] + '","s_pos_x":"' + s_pos_x + '","s_pos_y":"' + s_pos_y + '"}';
                $.ajax({
                    type: "post",
                    url: url,
                    contentType: 'application/json',
                    data: formativeData,
                    dataType: 'json',
                    success: function (data) {

                        nav[currentImage] = data.Str_Return;

                        //                mark_pos[currentImage]=$("#Text2").val()+","+$("#Text3").val()+"|"+$("#Text4").val()+","+$("#Text5").val();
                        mark_pos[currentImage] = str1[0] + "," + str1[1];

                        gradient = context.createLinearGradient(s_pos_x, s_pos_y, str[0], str[1]);
                        //				if(count==0)
                        {
                            clearInterval(timeroom);
                            clearInterval(timeperson);
                            timeperson = setInterval(function () { animate(); navigate(); }, 200);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(1);
                        alert(XMLHttpRequest.responseText);
                    },
                    cache: false
                });       */

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(2 + "person");
                alert(XMLHttpRequest.responseText);
                //                $("#divMessagePanel").html("error");
            },
            cache: false
        });


    } 

function searchRoom() {//搜索会议室坐标


		//var id="FQ3_3F03@Ctrip.com";
		var id=choosedRoom;

		var url=location.href;
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/GIS/GIS01/Search_Entity_POS";
			var formativeData='{"Str_Site":"fq","search_key":"'+id+'"}';
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {


 					location1= data[0].Str_Return; //目标位置各顶点坐标


               
                var str = new Array();
                if (location1!= "")
                    str = location1.split('|'); //alert(location1[currentImage])
                    
        var location1=data[0].Str_Return;	//目标位置各顶点坐标
        var str=new Array();        
        if(location1!="")
        str=location1.split('|');
       // alert(location1);
       // alert(str);
        var str1=new Array();
        str1=str[0].split(',');
			//	alert(str1);
				drawMark( "infobox" ,str1[0],str1[1]);



            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(2+"room")  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });

    
} 　




function showPersonDetail(){  //显示员工信息
		//var id="s26618";
	  var id=choosedPerson;

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
            	
            	
            	document.getElementById('message').innerHTML=data[1].Str_Value;
            	document.getElementById('gothere').innerHTML=data[4].Str_Value;

		
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(2)  ;
                    alert(XMLHttpRequest.responseText);
            },
            cache: false
        });	
}


function showRoomDetail(){ //显示会议室信息
		//var id="FQ3_3F03@Ctrip.com";
		var id=choosedRoom;
    var formativeData='{"Str_SearchKey":"'+id+'","Str_Site":"fq"}';
		var url=location.href;
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/Exchange/Exchange01/Load_MeetingRoom_DetailInfo_by_Address";
		$.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
        
     //    	document.getElementById('message').innerHTML=data[1].Str_Value;
     //     document.getElementById('gothere').innerHTML=data[5].Str_Value;

        
					document.getElementById('message').innerHTML=data[1].Str_Value;
				  var logo="";
					for(var i=4;i<data.length;i++)
					{
					if(data[i].Str_Value)				
 					logo+=data[i].Str_Key+" ";
					}
				  document.getElementById('gothere').innerHTML=logo;

				
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(21)  ;
                    alert(XMLHttpRequest.responseText);
            },
            cache: false
        });	
}
function showDeptDetail(){ //显示部门信息
	
		document.getElementById('message').innerHTML=DeptName;
		document.getElementById('gothere').innerHTML="";

	
}


