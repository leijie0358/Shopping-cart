<script>
$(document).ready(function(){
	sel_pro = document.getElementById('company_addr_province'); 
	sel_city = document.getElementById('company_addr_city'); 
	
	$('.prompt_type').change(function(){
		name = $(this).attr('name');
		// alert(name);
		id = "tr_" + name + "_param";
		if($(this).attr('checked'))
		{
			$('#'+id).css('display','');
		}
		else
		{
			$('#'+id).css('display','none');
		}
	});

	$('.prompt_type').change();

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
			
			var p = "<?=$company_addr_province?>";
			var c = "<?=$company_addr_city?>";

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
			});
	
			$("#company_addr_province").change(function(){
				sindex = $(this)[0].selectedIndex;
				$("#company_addr_city").empty(); 
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
			
			$("#company_addr_province").change();             
		},
		complete: function(XMLHttpRequest, textStatus){
		},
		error: function(){
			//alert("ddd");
		}
	});
});
</script>
<div class="login_error_prompt" style='padding-left:2px;height:10px'><?=$error?></div> 
<div style="width:780px;">
<form action="<?=$action?>" method="post" id="sysform">
	<table>
		<tr>
			<td width="100">  
				公司名称
			</td>
			<td>
				<input size="30"  type="text" name="company_name" value="<?=$company_name ?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				公司地址
			</td>
			<td>
				<select name="company_addr_province" id="company_addr_province" >
					<option value="<?=$company_addr_province?>">北京市</option>
				</select>
				<select name="company_addr_city" id="company_addr_city">
					<option value="<?=$company_addr_city?>">朝阳区</option>
				</select>
				<input size="36" type="text" name="company_addr_detail" value="<?=$company_addr_detail ?>"></input>
			</td>
		</tr>
		
		<tr>
			<td>
				坐标-经度
			</td>
			<td>
				<input type="text" name="lng" readonly value="<?=$lng ?>"></input>
				* 公司所在城市的地理坐标 ,用于地图搜索(试用不开放更改)
			</td>
		</tr>
		<tr>
			<td>
				坐标-纬度
			</td>
			<td>
				<input type="text" readonly name="lat" value="<?=$lat ?>"></input>
				* 公司所在城市的地理坐标 ,用于地图搜索(试用不开放更改)
			</td>
		</tr>
		<tr>
			<td>
				公交站点
			</td>
			<td>
				<input type="text" readonly size="60" name="company_transit_station" value="<?=$company_transit_station ?>"></input>  
				* 公司周围的公交站点   多个用","号分开  (试用不开放更改)
			</td>
		</tr>
		<tr>
			<td>
				谷歌地图KEY
			</td>
			<td>
				<textarea  readonly  name="gmap_key"  cols="60" rows="3"><?=$gmap_key ?></textarea>(试用不开放更改)
			</td>
		</tr>
		<tr>
			<td>
				提示方式
			</td>
			<td>
				<input type="checkbox" name="prompt_type_email" class="prompt_type" <?=$prompt_type_email?"checked":""?> /> 发送邮件 
				<input type="checkbox" name="prompt_type_sms" class="prompt_type" <?=$prompt_type_sms?"checked":""?> /> 短信提醒 
				<input type="checkbox" name="prompt_type_audio" class="prompt_type" <?=$prompt_type_audio?"checked":""?> /> 语音提示 * 
				当有新的报修单进来的时候的提示方式
			</td>
		</tr>
		<tr id="tr_prompt_type_email_param" style="display:none;">
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;管理员邮箱
			</td>
			<td>
				<input  size="28"  type="text" name="admin_email" value="<?=$admin_email ?>"></input>
			</td>
		</tr>
		<tr id="tr_prompt_type_sms_param" style="display:none;"> 
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;管理员手机
			</td>
			<td>
				<input type="text" name="admin_mobilephone" value="<?=$admin_mobilephone ?>"></input>
			</td>
		</tr>
		<tr id="tr_prompt_type_audio_param" style="display:none;">
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;提示规则
			</td>
			<td>
				表达式:<br><textarea  cols="60" rows="3" readonly name="prompt_audio_expression"><?=$prompt_audio_expression?></textarea>(*试用不开放更改)<br/>
				间隔:<input type="text" style="width:10px;" readonly name="prompt_audio_expireduration" value="<?=$prompt_audio_expireduration ?>"></input> 小时 * 假如现在时间为10点钟，设定值为2，则表示8点以前的报修信息将不再语音提示了。
			</td>
		</tr>
		
		
				
	</table>
	<br>
	<input type="submit" class='btn' value="  设  置   " />
</form>
</div>
