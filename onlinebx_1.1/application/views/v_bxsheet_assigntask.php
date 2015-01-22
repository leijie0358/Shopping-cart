<?php
//	require_once("/application/controllers/bxsheet.php");
	require_once 'v_head.php';
//	Bxsheet::index();
?>
<style>
.bxsheet_show
{
	border-bottom: 1px solid #666666;
}
.show td
{
	padding-top:6px;
	padding-bottom:6px;
}
</style>

<script>
$(function() {
	$( "#booking_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	});
});
$(document).ready(function(){	
	$("#engineers").change(function(){
		$("#engineers").val(null);
		var len=$("#engineers").select2("data").length;
		for(var i=0;i<len;i++){
			var temp=$("#engineers").val();
			$("#engineers").val(temp+","+i+","+$("#engineers").select2("data")[i].tag);
		}
	});
$("#engineers").select2({					
	placeholder: "Search for a person",
	minimumInputLength: 2,
	multiple:true,
	query: function (query){
		var data2 = {results: []};

send_request('<?=$root_url?>application/views/try2.php','POST',query.term);
http_request.onreadystatechange=function processrequest(){
if(http_request.readyState==4){//判断对象状态
  if(http_request.status==200){//信息已成功返回，开始处理信息
	  var a=eval(decodeURIComponent(http_request.responseText));
		for(var i=0;i<a.length;i++)
			data2.results.push({id:i, tag:a[i].shortName});
		query.callback(data2);		
  }else{//页面不正常
      alert("您所请求的页面不正常！");
  }
}
}

	},
	formatSelection: format,
	formatResult: format
					});	
});
function format(item) { return item.tag; }



function send_request(url,method,term){//初始化，指定处理函数，发送请求的函数
	http_request=false;
	//开始初始化XMLHttpRequest对象
	if(window.XMLHttpRequest){//Mozilla浏览器
	  http_request=new XMLHttpRequest();
	  if(http_request.overrideMimeType){//设置MIME类别
		http_request.overrideMimeType("text/xml");
	  }
	}
	else if(window.ActiveXObject){//IE浏览器
	  try{
	   http_request=new ActiveXObject("Msxml2.XMLHttp");
	  }catch(e){
	   try{
	   http_request=new ActiveXobject("Microsoft.XMLHttp");
	   }catch(e){}
	  }
		}
	if(!http_request){//异常，创建对象实例失败
	  window.alert("创建XMLHttp对象失败！");
	  return false;
	}
	
	//确定发送请求方式，URL，及是否同步执行下段代码   
	
	
	if(method=='GET'){//GET方式发送数据
	  url=url+"?"+$('data').id+'='+$('data').value+'&timestamp=' + Math.random();
	   http_request.open('GET',url,true);
	   http_request.send(null);
	
	}else if(method=='POST'){//POST方式发送数据
	  http_request.open('POST',url,true);
	  http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	  http_request.send('data='+term);
	
	}   
}
</script>

<form action="<?=$action?>" method="post" id="assigntaskform"> 
<table class="show" align="center">
	<tr>
		<td width="90">
			报修编号
		</td>
		<td>
			<label class="bxsheet_show"><?=$number?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修部门
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_company?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			姓名
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_name?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=date("Y-m-d H:i",strtotime($bx_time))?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			维修地点 
		</td>
		<td>
			<label class="bxsheet_show">北京市朝阳区<?=$custom_addr_detail?>&nbsp;</label>
		</td>
	</tr>
	
	<tr>
		<td>
			工作电话	
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_workphone?>&nbsp;</label>
		</td>
	</tr>
	
	<tr>
		<td>
			手机	
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_mobilephone?>&nbsp;</label>
		</td>
	</tr>

	<tr>
		<td>
			希望维修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=date("Y-m-d H:i",strtotime($hope_wx_time_begin))?> -- <?=date("Y-m-d H:i",strtotime($hope_wx_time_end))?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			故障类别
		</td>
		<td>
			<label class="bxsheet_show"><?=$bxsheet_class_name?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修名称
		</td>
		<td>
			<label class="bxsheet_show"><?=$fault_title?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			故障现象
		</td>
		<td>
			<div class="bxsheet_show"><?=$fault_profile?>&nbsp;</div>
		</td>
	</tr>

	<tr>
		<td>
			预约时间
		</td>
		<td>
			<input type="text" name="booking_date" id="booking_date" size="10" value="<?=$booking_date?>"></input> 
			<select name="booking_time_hour">
			<? for($i=0;$i<=23;$i++){?>
				<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>"  <?= $booking_time_hour==$i?"selected":""?>>
					<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
				</option>
			<?}?>
			</select>
			:
			<select name="booking_time_minute">
			<? for($i=0;$i<=59;$i++){?>
				<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>" <?= $booking_time_minute==$i?"selected":""?>>
					<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
				</option>
			<?}?>
			</select>
		</td>
	</tr>

	<tr>
		<td>
			分配给
		</td>
		<td>
			<input type="text"  name="engineers[]" id="engineers" value="<?=$engineers?>" style="width:100%;"/>
		</td>
	</tr>
</table>
	
</form>
                <div align="center" style="padding: 0 0 20px 0">
                    
                        
                        
                        
                            <button class="btn btn-primary" onclick="showModel('w','派工',window.location.href,'assigntaskform');">
                                提交事件
                            </button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" onclick="saveForm();">
                                保存草稿
                            </button>
                        
                    
                </div>
<?php
//	require_once("/application/controllers/bxsheet.php");
	require_once 'v_foot.php';
//	Bxsheet::index();
?>
