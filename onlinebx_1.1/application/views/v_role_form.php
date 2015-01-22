<form action="<?=$action?>" method="post" id="roleform">
	<table>
		<tr>
			<td>
				类型
			</td>
			<td>
				<select name="type">
					<option value="0" <?=$type==0?"selected":""?>>默认</option>
					<option value="1" <?=$type==1?"selected":""?>>客户</option>
					<option value="2" <?=$type==2?"selected":""?>>工程师</option>
					<option value="3" <?=$type==3?"selected":""?>>超级管理员</option>  
				</select>
			</td>
		</tr>
		<tr>
			<td>
				角色名称
			</td>
			<td>
				<input type="text" name="name" value="<?=$name?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				说明
			</td>
			<td>
				<textarea name="profile" cols="30" rows="6"><?=$profile?></textarea>
			</td>
		</tr>
	</table>
</form>
