<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/style.css" /> 
	<title><?=$title?></title>
	<script>
	var browser=navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		var b_version=navigator.appVersion;
		//var version=parseFloat(b_version);
		pos = b_version.indexOf("MSIE");
		b_version = b_version.substring(pos+4);
		version = parseFloat(b_version);
		if(version < 7)
		{
			document.write("<center style='color:red;font-size:16px'>检测到你的浏览器为IE6及以下版本,为获得更好的显示效果,请选择IE7及以上或者非IE浏览器</center>");
		}
	}
	redirect($this->get_root_url()."index.php/user/loginpost");
	</script>
</head>
<body>
	<form method="post" action="<?=$root_url?>index.php/user/loginpost">
		<div id="container">
			<div class="login_main">
				<div class="login_adv"></div>
				<div class="login_area">
					<div class="login_title">
						在线报修 <a href="../../test.html" target="_blank" style="font-size:16px">前台演示[点击]</a>
					</div>
					<div class="login_error_prompt"><?=$error?></div>
					<div class="login_username">
						用户名 : <input class='login_input_text' type="text"  name="username" />
					</div>
					<div class="login_password">
						密&nbsp;&nbsp;&nbsp;&nbsp;码 : <input class='login_input_text' type="password" name="password" />
					</div>
					<div class="login_button"> 
						<table><tr>
							<td>快速 <input type="checkbox" name='db_grid_type' /></td>
							<td><a href='http://www.ctrip.com' target="_blank">携程软件</a></td>
							<td><input type='submit' class="login_input_submit" value="" /></td>
						</tr></table>
					</div>
				</div>
				
				<div style="clear:both"></div>
				<div id="login_footer"> 
					<script language="javascript" type="text/javascript" src="http://js.users.51.la/4676206.js"></script>
					<noscript>
						<a href="http://www.ctrip.com" target="_blank">
						<img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/4676206.asp" style="border:none" />
						</a>
					</noscript>
				</div>
			</div>

			
		</div>
	</form>
</body>
</html>