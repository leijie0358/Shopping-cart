window.onload = function(){
	
		  // alert("hello");

	//��ʼ��������ҳtab��С����
	VirtualKeyboard.show('searchbox1','softkey1');
	 $("#kb_langselector,#kb_mappingselector,#copyrights").css("display", "none");
	
	 getMeetingRoom();//��ʼ����ʾ���л�����
	 showDepList();//��ʼ����ʾ���в�������
	
	document.getElementById('infobox').style.display='none'; 

	
}

function showtabPerson(){

		document.getElementById("linktab1").click(); 

	}
	function showtabDept(){
	
document.getElementById("linktab2").click(); 

	}
	function showtabRoom(){
	
document.getElementById("linktab3").click(); 
		
	}



function keyboard1() {//���tab1����ͬ�¡�����ʾС���̣�����������ҳС����
	 VirtualKeyboard.hide('searchbox2', 'softkey2');
	  VirtualKeyboard.hide('searchbox3', 'softkey3');
	
        VirtualKeyboard.show('searchbox1', 'softkey1');
       $("#kb_langselector,#kb_mappingselector,#copyrights").css("display", "none");
    }
function keyboard2() {//���tab2���Ҳ��š�����ʾС���̣�����������ҳС����
	 VirtualKeyboard.hide('searchbox1', 'softkey1');
	  VirtualKeyboard.hide('searchbox3', 'softkey3');
	  
        VirtualKeyboard.show('searchbox2', 'softkey2');
       $("#kb_langselector,#kb_mappingselector,#copyrights").css("display", "none");
    }


 function keyboard3() {//���tab3���һ����ҡ�����ʾС���̣�����������ҳС����
 	 VirtualKeyboard.hide('searchbox2', 'softkey2');
	  VirtualKeyboard.hide('searchbox1', 'softkey1');
 	
        VirtualKeyboard.show('searchbox3', 'softkey3');
       $("#kb_langselector,#kb_mappingselector,#copyrights").css("display", "none");
    }



function clickremove1(){//tab1����ͬ�¡� ���������
	
	document.getElementById("searchbox1").value="";
		
}
function clickremove2(){//tab2���Ҳ��š����������
	
	document.getElementById("searchbox2").value="";
		
}
function clickremove3(){//tab2���һ����ҡ����������
	
	document.getElementById("searchbox3").value="";
		
}
function clicksearch1(){//tab1����ͬ�¡� ����������������ͬ��
	
	//document.getElementById("searchbox1").value="";
	
	getListByName();
					
}

function clicksearch2(){//tab2���Ҳ��š� ��������������������
	
	
	//showDepList();
	getDepList();
	
}

function clicksearch3(){//tab3���һ����ҡ� ����������������������
	
	 getMeetingRoom();
	}



/*
http://localhost:8092/Exchange/Exchange01/Get_UserList_byKey
{
	"Str_SearchKey":"zzz",
	"Str_Site":"fq"
}

"Str_Address":"�ַ�������",
	"Str_Name":"�ַ�������"

*/
function getListByName(){// ����������������ͬ��
	
	
	if($("#searchbox1").value!="")
	{
	
	  //var searchKey=$("#searchbox1").value;
	  var searchKey= document.getElementById("searchbox1").value;
	 //��ȡ��ǰ��ַ���磺 http://localhost:8083/uimcardprj/share/meun.jsp   
	  var curWwwPath=window.document.location.href;   
	 //��ȡ������ַ֮���Ŀ¼���磺 uimcardprj/share/meun.jsp   
	  var pathName=window.document.location.pathname;   
	  var pos=curWwwPath.indexOf(pathName);
	 //��ȡ������ַ���磺 http://localhost:8083   
	  var localhostPath=curWwwPath.substring(0,pos);
	  var fullpath=localhostPath+"/Exchange/Exchange01/Get_UserList_byKey";
	
		var site="fq";
    //var formativeData ='{}';
    var formativeData='{"Str_SearchKey":"'+searchKey+'","Str_Site":"'+site+'"}';
    $.ajax({
        type: "post",     
        url:fullpath,
        contentType: 'application/json',
        data:formativeData,
        dataType: 'json',  
        charset:'gb2312', 
        success: function(data) 
        {
            
            //t=document.getElementById("personlist");
            
            var bylistlen = data.length;
            if (bylistlen==0) 
            {
                alert("No available person!");
            }
            else
            {
            document.getElementById('personlist').innerHTML="";
            
            for(var i=0;i<bylistlen;i++)
            	{
            		
            		//var regex = /\([^\)]+\)/g;
            		
            		//var v = regex.exec(data[i].Str_Name);
            		//var email="(zhang.zj@ctrip.com)";

            		
            	//	pattern =new RegExp("\\((.| )+?\\)","igm"); 
            	//	arr_name[i]=data[i].Str_Name.match(pattern);
            	//	var tmp=email.match(pattern);            		
            	//	var tmp2=email.substr(email.indexOf("(")+1,email.indexOf(")")-1);           		
             	//	alert(tmp+" "+tmp2);
             		
             		//var tmp=data[i].Str_Name.match(pattern);            		
            		var tmp2=data[i].Str_Name.substring(data[i].Str_Name.lastIndexOf("(")+1,data[i].Str_Name.lastIndexOf(")"));           		
            		//var tmp2=tmp.substr(tmp.indexOf("(")+1,tmp.indexOf(")")-1);           		

             		//alert(tmp+" "+tmp2);
             		
             		
            		//alert(arr_name[i]);            		           		
            	  arr_name[i]=tmp2;////////////////////////////////////////////
            	  
            	x= data[i].Str_Name;
            	 //document.getElementById('personlist').innerHTML+="<a href='#' class='list-group-item btn'  name='' value='"+data[i].Str_Address+"' onclick='choosePerson(this)'><img src='' class='img-circle' id='"+arr_name[i]+"'>"+x+"</a>";
            //	 document.getElementById('personlist').innerHTML+="<label class='list-group-item btn'   value='"+data[i].Str_Address+"' onclick='choosePerson(this)'><img src='' class='img-circle' id='"+arr_name[i]+"'>"+x+"</label>";
            	 document.getElementById('personlist').innerHTML+="<label class='list-group-item btn'><input type='radio'  value='"+data[i].Str_Address+"' onchange='choosePerson(this)' ><img src='img/person.png' class='img-circle' id='"+arr_name[i]+"'>"+x+"</label>";

//<label class="list-group-item btn"  > <input type="radio"  value="zzj" onchange="chooseradio(this)" ><img src="img/person.png" class="img-circle">���Ӽ�</label>
                
          		}
          		
          		get_lync_status();
          	}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) 
        {
            
            alert(XMLHttpRequest.responseText);

        },
        cache: false
    }); 
  
  }
  
  else alert("please input a name");
}


/*

http://localhost:8094/Exchange/Exchange01/Get_DeptList_byKey


{
	"Str_SearchKey":"",
	"Str_Site":"fq"
}

*/

function showDepList(){//�������в��� ��ʼ��������ʾ
	
	
	  //var searchKey= document.getElementById("searchbox2").value;
	  var curWwwPath=window.document.location.href;   
	  var pathName=window.document.location.pathname;   
	  var pos=curWwwPath.indexOf(pathName);
	  var localhostPath=curWwwPath.substring(0,pos);
	  var fullpath=localhostPath+"/Exchange/Exchange01/Get_DeptList_byKey";
	
		var searchKey="";
		var site="fq";
    //var formativeData ='{}';
    var formativeData='{"Str_SearchKey":"'+searchKey+'","Str_Site":"'+site+'"}';
    $.ajax({
        type: "post",     
        url:fullpath,
        contentType: 'application/json',
        data:formativeData,
        dataType: 'json',  
        charset:'gb2312', 
        success: function(data) 
        {
            
            //t=document.getElementById("personlist");
            
            var bylistlen = data.length;
            if (bylistlen==0) 
            {
                alert("No available Dept!");
            }
            else
            {
            document.getElementById('grouplist').innerHTML="";
            
            for(var i=0;i<bylistlen;i++)
            	{
            	x= data[i].Str_Name;
            	 document.getElementById('grouplist').innerHTML+="<label class='btn btn-default' ><input type='radio' name='"+x+"' id='singledept' value='"+data[i].Str_Address+"' onchange='chooseDept(this)'>"+x+"</label>";
            	    //       ����   </label>             
          		}
          	}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) 
        {
            
            alert(XMLHttpRequest.responseText);

        },
        cache: false
    }); 
	
	
}





function getDepList(){//����������������������
	
	  var searchKey= document.getElementById("searchbox2").value;
	  var curWwwPath=window.document.location.href;   
	  var pathName=window.document.location.pathname;   
	  var pos=curWwwPath.indexOf(pathName);
	  var localhostPath=curWwwPath.substring(0,pos);
	  var fullpath=localhostPath+"/Exchange/Exchange01/Get_DeptList_byKey";
	
		//var searchKey="";
		var site="fq";
    //var formativeData ='{}';
    var formativeData='{"Str_SearchKey":"'+searchKey+'","Str_Site":"'+site+'"}';
    $.ajax({
        type: "post",     
        url:fullpath,
        contentType: 'application/json',
        data:formativeData,
        dataType: 'json',  
        charset:'gb2312', 
        success: function(data) 
        {
            
            //t=document.getElementById("personlist");
            
            var bylistlen = data.length;
            if (bylistlen==0) 
            {
                alert("No available Dept!");
            }
            else
            {
            document.getElementById('grouplist').innerHTML="";
            
            for(var i=0;i<bylistlen;i++)
            	{
            	x= data[i].Str_Name;
            	 document.getElementById('grouplist').innerHTML+="<label class='btn btn-default' ><input type='radio' name='"+x+"' id='singledept' value='"+data[i].Str_Address+"' onchange='chooseDept(this)'>"+x+"</label>";
            	    //       ����   </label>             
          		}
          	}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) 
        {
            
            alert(XMLHttpRequest.responseText);

        },
        cache: false
    }); 
	
	
	
	
}



function getMeetingRoom(){//����������������������
	
	
	if($("#searchbox3").value!="")
	{
	
	  var searchKey= document.getElementById("searchbox3").value;
	  var curWwwPath=window.document.location.href;   
	  var pathName=window.document.location.pathname;   
	  var pos=curWwwPath.indexOf(pathName);
	  var localhostPath=curWwwPath.substring(0,pos);
	  var fullpath=localhostPath+"/Exchange/Exchange01/Get_MeetingRoomList_byKey";
	
		var site="fq";
    //var formativeData ='{}';
    var formativeData='{"Str_SearchKey":"'+searchKey+'","Str_Site":"'+site+'"}';
    $.ajax({
        type: "post",     
        url:fullpath,
        contentType: 'application/json',
        data:formativeData,
        dataType: 'json',  
        charset:'gb2312', 
        success: function(data) 
        {
            
            //t=document.getElementById("personlist");
            
            var bylistlen = data.length;
            if (bylistlen==0) 
            {
                alert("No available MeetingRoom!");
            }
            else
            {
            document.getElementById('roomlist').innerHTML="";
            
            for(var i=0;i<bylistlen;i++)
            	{
            	x= data[i].Str_Name;
            //	 document.getElementById('roomlist').innerHTML+="<a href='#' class='list-group-item btn' id='singlePerson' name='' value='"+data[i].Str_Address+"' onclick='chooseMeeting(this)'><img src='img/person.png' class='img-circle' >"+x+"</a>";
            //	 document.getElementById('roomlist').innerHTML+="<label class='list-group-item btn'  value='"+data[i].Str_Address+"' onclick='chooseMeeting(this)'><img src='img/person.png' class='img-circle' >"+x+"</label>";
             	 document.getElementById('roomlist').innerHTML+="<label class='list-group-item btn' ><input type='radio'  value='"+data[i].Str_Address+"' onchange='chooseMeeting(this)'><img src='img/person.png' class='img-circle' >"+x+"</label>";

                
          		}
          	}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) 
        {
            
            alert(XMLHttpRequest.responseText);

        },
        cache: false
    }); 
  
  }
}



 				//initializeObject();
        var NameObj;
        var StatusID;
        //var arr_name = new Array("shengyanli@ctrip.com", "zhang.zj@ctrip.com");
        var arr_name=new Array();
        var arr_id = new Array();
        function initializeObject() {
            NameObj = new ActiveXObject('Name.NameCtrl.1');
            NameObj.OnStatusChange = MyOnStatusChange;

        }
       
 

        function get_lync_status() {  //��ȡLync״̬
        		initializeObject();
           

							for(var i=0;i<arr_name.length;i++)
									{
										arr_id[i]=arr_name[i];
	 									NameObj.GetStatus(arr_name[i], arr_id[i]);
									}
          
            
            

        }

        function MyOnStatusChange(name, status, id) {
           //  alert(name+"|"+status+"|"+id);
             var img = document.getElementById(id);

             var imgid=[0,1,2,3,6,9];
             if(imgid.indexOf(status)<0){
             	img.src = "img/person.png";

            }
            else 
            img.src = "img/" + status + ".png";
        }

//////////////////////////////////////////////////////////



function choosePerson(obj){ //���Ա�������¼�
    $("#div_search_main").hide();
	//var currentID=obj.value;//��ȡ����ؼ���ֵ
	//document.getElementById("test").innerHTML=currentID;
	choosedPerson=obj.value;
	searchPerson();
	showPersonDetail();
}

function chooseDept(obj) {//������Ŵ����¼�
    $("#div_search_main").hide();
	//var currentID=obj.name;//��ȡ����ؼ���ֵ
	//document.getElementById("test").innerHTML=currentID;
	choosedDept=obj.value;
	DeptName=obj.name;
	searchDept();
	showDeptDetail()

}
function chooseMeeting(obj) {//��������Ҵ����¼�
    $("#div_search_main").hide();
	//var currentID=obj.value;//��ȡ����ؼ���ֵ
	//document.getElementById("test").innerHTML=currentID;
	choosedRoom=obj.value;
	searchRoom();
	showRoomDetail();
}

var choosedPerson;
var choosedDept;
var choosedRoom;
var DeptName;




