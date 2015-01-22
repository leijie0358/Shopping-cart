<?php
//	require_once("/application/controllers/bxsheet.php");
	require_once 'v_head.php';
//	Bxsheet::index();
?>




<script>
	$(function() {
		$( "#hope_wx_date_begin" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		$( "#hope_wx_date_end" ).datepicker({
			changeMonth: true,
			changeYear: true, 
			dateFormat: "yy-mm-dd"
		});
		$( "#bx_date" ).datepicker({
			changeMonth: true,
			changeYear: true, 
			dateFormat: "yy-mm-dd"
		});
	}); 

	$(document).ready(function(){
		
		sel_pro = document.getElementById('custom_addr_province');
		sel_city = document.getElementById('custom_addr_city'); 
		//alert(sel_pro);

		//$("<option value='a'>a</option>").appendTo($('#custom_addr_province'));
		// 设置行政区划
		$.ajax({
			type: "get",
			url: "<?=$root_url?>application/views/scripts/political_area.js",
			//dataType : "json",
			beforeSend: function(XMLHttpRequest){
			},
			success: function(data, textStatus){
				//eval("a ='" + data + "'");
				data = data.replace(/\r/g,"");
				data = data.replace(/\n/g,"");
				data = data.replace(/\r\n/g,"");
				data = data.replace(/\s/g,"");
				eval("pa =" + data + ";");
				//alert(data);
				var p = "<?=$custom_addr_province?>";
				var c = "<?=$custom_addr_city?>";

				// city = document.getElementById('custom_addr_city');
				
				$.each(pa.provinces,function(index,province){ 
					//alert(province.name); 
					option =
						"<option value='" + province.name + "'" + ((p==province.name)?'selected':'') + ">" + province.name + "</option>";

				
					//if (navigator.appName == 'Microsoft Internet Explorer')
					{
						option = new Option(province.name, province.name);

						if(p==province.name)
						{
							option.selected = true;
						}

						sel_pro.options[sel_pro.options.length] = option;
					}
					
					
					// $("#custom_addr_province").append(option);
				
				});
		
				$("#custom_addr_province").change(function(){
					sindex = $(this)[0].selectedIndex;
					$("#custom_addr_city").empty(); 
					$.each(pa.provinces[sindex].citys,function(index,city){
						option = 
							"<option value='"+city.name + "'" + ((c==city.name)?'selected':'') + ">" + city.name + "</option>";

						//if (navigator.appName == 'Microsoft Internet Explorer')
						{
							option = new Option(city.name,city.name);

							if(c == city.name)
							{
								option.selected = true;
							}

							sel_city.options[sel_city.options.length] = option;
						}
						
						// $("#custom_addr_city").append(option); 
					});
				});
				
				$("#custom_addr_province").change();

				// alert($("#custom_addr_province").css('width'));
			},
			complete: function(XMLHttpRequest, textStatus){
			},
			error: function(){
				//alert("ddd");
			}
		});


		

		
		$("#custom_name").change(function(){
			$("#custom_name").val($("#custom_name").select2("data").tag);
/*			sindex = $(this)[0].selectedIndex;
			option = $(this)[0].options[sindex];
			// alert(sindex);
			//alert(option.attributes["cinfo"].nodeValue);
			custominfo = option.attributes["cinfo"].nodeValue;
			//custominfo = $("#custom_id").find("option:selected").attr("cinfo");
			//alert(custominfo);
			if(custominfo == "")
			{
				$("#custom_company").val("");
				$("#custom_name").val(""); 
				return;
			}
			customcompany = custominfo.split('')[0];
			customname = custominfo.split('')[1];
			customworkphone = custominfo.split('')[2];
			custommobilephone = custominfo.split('')[3];
			work_addr_province = custominfo.split('')[4];
			work_addr_city = custominfo.split('')[5];
			work_addr_detail = custominfo.split('')[6];
			//alert(work_addr_province + "-" + work_addr_city + "-" + work_addr_detail);
			$("#custom_company").val(customcompany);
			$("#custom_name").val(customname); 
			$("#custom_workphone").val(customworkphone); 
			$("#custom_mobilephone").val(custommobilephone); 
			$("#custom_addr_province").val(work_addr_province); 
			//$("#custom_addr_province").options.each
			$("#custom_addr_city").val(work_addr_city); 
			$("#custom_addr_detail").val(work_addr_detail);*/  
		});
		<?
			if($this->session->userdata('user')!=null)
			{
				// 是客户又是添加
				if($this->session->userdata('user')->role_type==1)
				{
		?>
				$("#customid option").first().remove();
				<? if($this->uri->segment(2) == "add"){?>
				$("#customid").change();
				<?}?>
		<?	
				}
			}
		?>
    $("#custom_name").select2({					
		placeholder: "Search for a person",
		minimumInputLength: 2,
		query: function (query){
			var data2 = {results: []};
			var i=0;
			var b='lj';

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


<form action="<?=$action?>" method="post" id="bxsheetform">
	<table align="center" >
		<? if($is_show_number_row){?>
		<tr>
			<td>
				报修编号
			</td>
			<td>
				<input type="text" name="number" readonly value="<?=$number?>"></input>
			</td>
		</tr>
		<?}?>
		<tr class="custom">
			<td>
				申报人           
			</td>
			<td>
				 <input type="text"  name="custom_name" id="custom_name" value="<?=$custom_name?>" style="width:100%;"/>
			</td>
		</tr>
		<tr>
			<td>
				报修部门
			</td>
			<td>
				<input size="30" type="text" name="custom_company" id="custom_company" value="<?=$custom_company?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				报修时间
			</td>
			<td>
				<input type="text" name="bx_date" size="6" id="bx_date" value="<?=$bx_date?>"></input> 日
				<select name="bx_hour">
				<? for($i=0;$i<=23;$i++){?>
					<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>"  <?= $bx_hour==$i?"selected":""?>>
						<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
					</option>
				<?}?>
				</select>
				:
				<select name="bx_minute">
				<? for($i=0;$i<=59;$i++){?>
					<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>" <?= $bx_minute==$i?"selected":""?>>
						<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
					</option>
				<?}?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				报修名称
			</td>
			<td>
				<select name="custom_addr_province" id="custom_addr_province">

				</select>
				<select name="custom_addr_city" id="custom_addr_city"> 

				</select>
				<!--<select name="custom_addr_area">
					<option value="花山区" selected >花山区</option>
				</select>
				<select name="custom_addr_street">
					<option value="江东社区" selected >江东社区</option>
				</select>-->
				<input type="text" name="custom_addr_detail" id="custom_addr_detail" value="<?=$custom_addr_detail?>"></input> 
			</td>
		</tr>
		
		<tr>
			<td>
				工作电话	
			</td>
			<td>
				<input type="text" name="custom_workphone" id="custom_workphone" value="<?=$custom_workphone?>"></input>
			</td>
		</tr>
		
		<tr>
			<td>
				手机	
			</td>
			<td>
				<input type="text" name="custom_mobilephone"   id="custom_mobilephone" value="<?=$custom_mobilephone?>"></input> 
			</td>
		</tr>

		<tr>
			<td>
				希望维修时间
			</td>
			<td>
				<input type="text" name="hope_wx_date_begin" size="6" id="hope_wx_date_begin" value="<?=$hope_wx_date_begin?>"></input> 日
				<select name="hope_wx_hour_begin">
				<? for($i=0;$i<=23;$i++){?>
					<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>"  <?= $hope_wx_hour_begin==$i?"selected":""?>>
						<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
					</option>
				<?}?>
				</select>
				:
				<select name="hope_wx_minute_begin">
				<? for($i=0;$i<=59;$i++){?>
					<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>" <?= $hope_wx_minute_begin==$i?"selected":""?>>
						<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
					</option>
				<?}?>
				</select>
				--
				<input type="text" name="hope_wx_date_end" size="6" id="hope_wx_date_end" value="<?=$hope_wx_date_end?>"></input> 日
				<select name="hope_wx_hour_end">
				<? for($i=0;$i<=23;$i++){?>
					<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>" <?= $hope_wx_hour_end==$i?"selected":""?>>
						<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
					</option>
				<?}?>
				</select>
				:
				<select name="hope_wx_minute_end">
				<? for($i=0;$i<=59;$i++){?>
					<option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>" <?= $hope_wx_minute_end==$i?"selected":""?>>
						<?=str_pad($i,2,'0',STR_PAD_LEFT)?>
					</option>
				<?}?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				故障类别
			</td>
			<td>
				<select name="bxsheet_class_id" id="bxsheet_class_id">
				<?php foreach($bxsheet_classs as $bxsheet_class):?>
					<option value="<?=$bxsheet_class->id."-".str_replace("-","",$bxsheet_class->name)?>" <?= $bxsheet_class_id==$bxsheet_class->id? "selected" : ""?>>
						+<?=$bxsheet_class->name?>
					</option> 
				<?php endforeach;?>

				</select>
			</td>
		</tr>
		<tr>
			<td>
				报修名称
			</td>
			<td>
				<input type="text" name="fault_title" value="<?=$fault_title?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				故障现象
			</td>
			<td>
				<textarea cols="60" rows="6" name="fault_profile"><?=$fault_profile?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				处理结果
			</td>
			<td>
				<input type="text" name="result" value="<?=$result?>"></input>
			</td>
		</tr>		
		<tr>
			<td>
				签收人
			</td>
			<td>
				<input type="text" name="receiver" value="<?=$receiver?>"></input>
			</td>
		</tr>	
		<tr>
			<td>
				服务评价
			</td>
			<td>
				<select name="assessment_content" id="assessment_content">
					<option value="非常满意">非常满意</option> 
					<option value="满意">满意</option> 
					<option value="尚可">尚可</option> 
					<option value="不满意">不满意</option> 
				</select>
			</td>
		</tr>	
		<tr>
			<td>
				维修人
			</td>
			<td>
				<input type="text" name="service_person" value="<?=$service_person?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				主管
			</td>
			<td>
				<input type="text" name="supervisor" value="<?=$supervisor?>"></input>
			</td>
		</tr>		
	</table>
</form>
                <div align="center" style="padding: 0 0 20px 0">
                    
                        
                        
                        
                            <button class="btn btn-primary" onclick="showModel('w','添加报修单','<?=$root_url?>index.php/bxsheet/add','bxsheetform');">
                                提交事件
                            </button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" onclick='document.location.href="http://"+window.location.host+"/onlinebx_1.1/index.php/bxsheet";'>
                               返回
                            </button>
                        
                    
                </div>
<?php
//	require_once("/application/controllers/bxsheet.php");
	require_once 'v_foot.php';
//	Bxsheet::index();
?>