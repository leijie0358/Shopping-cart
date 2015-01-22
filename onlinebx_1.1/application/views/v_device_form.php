<script>
	$(document).ready(function(){
			
		$("#buy_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		
		<?=$json_device_classs?> 

		sel_type = document.getElementById('type');
		sel_brand = document.getElementById('brand');

		var type_id = '<?=$type?>';
		var brand_id = '<?=$brand?>';
		
		var i1 = 0;
		var i2 = 0;
		// alert(type_id);
		// alert(brand_id);
		$.each(types,function(index,type){
			// alert(type.name);
			
			option = new Option(type.name,type.id);

			// alert(type_id);

			if(type_id == type.id)
			{
				i1 = index;
			}

			sel_type.options[sel_type.options.length] = option;
		}); 
		sel_type.selectedIndex = i1;

		$("#type").change(function(){
			sindex = $(this)[0].selectedIndex;
			//alert(sindex);
			$("#brand").empty(); 
			//option = new Option('欢迎页面','welcome');
			//sel_brand.options[sel_brand.options.length] = option;
			$.each(types[sindex].brands,function(index,brand){
				option = new Option(brand.name,brand.id);
				if(brand_id == brand.id)
				{
					i2 = index;
				}
				sel_brand.options[sel_brand.options.length] = option;
			});
			sel_brand.selectedIndex = i2;     
		});

		$("#type").change();

	});
</script>

<form action="<?=$action?>" method="post" id="deviceform">
	<table>
		<tr>
			<td>
				设备编号
			</td>
			<td>
				<input type="text" name="number" value="<?=$number?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				设备类型
			</td>
			<td>
				<select name="type" id="type">
				</select>
				<select name="brand" id="brand"> 
				</select>
				型号:<input type="text" name="model"  value="<?=$model?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				购买日期
			</td>
			<td>
				<input type="text" name="buy_date" id="buy_date" value="<?=$buy_date?>"></input> 
			</td>
		</tr>
			
		<tr>
			<td>
				所属客户
			</td>
			<td>
				<select name="custom" id="custom">
					<?php foreach($customs as $custom):?>
					<option value="<?=$custom->id?>" <?= $user==$custom->id?"selected":""?>>
						<?=$custom->company."-".$custom->realname?>
					</option>
					<?php endforeach;?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>
				备注
			</td>
			<td>
				<textarea cols="60" rows="3" name="profile"><?=$profile?></textarea>
			</td>
		</tr>
		
		
		
	</table>
</form>
