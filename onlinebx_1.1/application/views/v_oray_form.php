<div style="font-size:12px;line-height:20px;margin-bottom:10px;">说明:如果你已经注册了向日葵帐号,直接讲帐号和密码填入下面即可。如果你还没有注册向日葵密码，请在下面的框架内注册一个用户名和密码.提示注册成功后，将你刚才注册的用户名和密码填入下面的用户名和密码框即可<br>
</div>
<iframe style="width:640px;height:300px;border:1px solid #888888;margin-bottom:10px" src="https://console.oray.com/passport/register.html?fromurl=https%3A%2F%2Fconsole.oray.com%2Faccount%2Fprofile%2F" />
<form action="<?=$action?>" method="post" id="orayform">
	<table>
		<tr>
			<td>
				向日葵帐户
			</td>
			<td>
				<input type="text" name="username" value="<?=$username?>"></input>
			</td>
			<td>
				密码
			</td>
			<td>
				<input type="password" name="password" value="<?=$password?>"></input>
			</td>
		</tr>
		<tr>
			<td>
				简要说明
			</td>
			<td colspan="3">
				<textarea name="profile" cols="60" rows="3"><?=$profile?></textarea>
			</td>
		</tr>
	</table>
</form>
