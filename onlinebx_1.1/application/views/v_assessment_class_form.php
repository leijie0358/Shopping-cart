<form action="<?=$action?>" method="post" id="assessment_classform">
	<table>
		<tr>
			<td>
				类别名称
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
