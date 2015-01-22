<script>
	$(document).ready(function(){
		sel_pro = document.getElementById('work_addr_province');
		sel_city = document.getElementById('work_addr_city'); 
		//alert(pro);

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
				
				var p = "<?=$work_addr_province?>";
				var c = "<?=$work_addr_city?>";

				// city = document.getElementById('custom_addr_city');
				
				$.each(pa.provinces,function(index,province){ 
					//alert(province.name); 
					option =
						"<option value='" + province.name + "'" + ((p==province.name)?'selected':'') + ">" + province.name + "</option>";

				//alert(province.name);
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
		
				$("#work_addr_province").change(function(){
					sindex = $(this)[0].selectedIndex;
					$("#work_addr_city").empty(); 
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
				
				$("#work_addr_province").change();

				// alert($("#custom_addr_province").css('width'));
			},
			complete: function(XMLHttpRequest, textStatus){
			},
			error: function(){
				//alert("ddd");
			}
		});

		$('#banned').change(function(){
			sindex = $(this)[0].selectedIndex;
			if(sindex == 1)
			{
				$('#ban_reason_div').css('display','');
			}
			else
			{
				$('#ban_reason_div').css('display','none');
			}
		});
		$('#banned').change();

		<?=$json_roles?>  

		
		sel_role = document.getElementById('role');
		sel_res = document.getElementById('resource');

		var role_id = '<?=$role_id?>';
		var resource_name = '<?=$controller?>';
		
		var i1 = 0;
		var i2 = 0;
		// alert(role_id);
		// alert(resource_name);
		$.each(roles,function(index,role){
			// alert(role.name);
			
			option = new Option(role.name,role.id);

			// alert(role_id);

			if(role_id == role.id)
			{
				i1 = index;
			}

			sel_role.options[sel_role.options.length] = option;
		}); 
		sel_role.selectedIndex = i1;

		$("#role").change(function(){
			sindex = $(this)[0].selectedIndex;
			//alert(sindex);
			$("#resource").empty(); 
			//option = new Option('欢迎页面','welcome');
			//sel_res.options[sel_res.options.length] = option;
			$.each(roles[sindex].resources,function(index,resource){
				option = new Option(resource.chinesename,resource.name);
				if(resource_name == resource.name)
				{
					i2 = index;
				}
				sel_res.options[sel_res.options.length] = option;
			});
			sel_res.selectedIndex = i2;     
		});

		$("#role").change();
	});
</script>

<form action="<?=$action?>" method="post" id="userform">
	<table>
		<tr>
			<td>
				登录名
			</td>
			<td>
				<input type="text" name="username" value="<?=$username?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				姓名
			</td>
			<td>
				<input type="text" name="realname" id="realname" value="<?=$realname?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				密码
			</td>
			<td>
				<input type="password" name="password" value="<?=$password?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				确认密码
			</td>
			<td>
				<input type="password" name="confirmpassword"></input>
			</td>
		</tr>
		<tr>
			<td>
				角色
			</td>
			<td>
				<select name="role" id="role">
			
				</select>
			</td>
		</tr>
		<tr>
			<td>
				默认页面
			</td>
			<td>
				<select name="resource" id="resource">
			
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Email
			</td>
			<td>
				<input type="text" name="email"  value="<?=$email?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				工作电话
			</td>
			<td>
				<input type="text" name="workphone"  value="<?=$workphone?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				手机
			</td>
			<td>
				<input type="text" name="mobilephone"  value="<?=$mobilephone?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				报修部门名称
			</td>
			<td>
				<input size="36"  type="text" name="company"  value="<?=$company?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				部门
			</td>
			<td>
				<input size="20"  type="text" name="department" value="<?=$department?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				报修部门地址
			</td>
			<td>
				<!--input size="56" type="text" name="workaddress" value="<?=$workaddress?>"></input-->

				<select name="work_addr_province" id="work_addr_province">
				</select>
				<select name="work_addr_city" id="work_addr_city"> 
				</select>
				<input type="text" name="work_addr_detail" size="40" value="<?=$work_addr_detail?>"></input>

			</td>
		</tr>
		
		<tr>
			<td>
				是否禁用
			</td>
			<td>
				<!--input size="56" type="text" name="workaddress" value="<?=$workaddress?>"></input-->
				<div style="float:left">
				<select name="banned" id="banned">
					<option <?=$banned=="0"?'selected':''?> value='0'>否</option>
					<option <?=$banned=="1"?'selected':''?> value='1'>是</option>
				</select>
				</div>
				<div id="ban_reason_div">
				禁用理由:
				<select name="ban_reason" id="ban_reason"> 
					<option value=''>无</option>
					<option <?=$ban_reason=="离职"?'selected':''?> value='离职'>离职</option>
					<option <?=$ban_reason=="客户已不联系"?'selected':''?>  value='客户已不联系'>客户已不联系</option>
				</select>
				</div>

			</td>
		</tr>
	</table>
</form>
