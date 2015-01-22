<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0039)https://console.oray.com/passport/login -->
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META content="text/html; charset=utf-8" http-equiv=Content-Type />
<script type="text/javascript" src="<?=$root_url?>application/views/scripts/jquery-1.5.1.js"></script>
<SCRIPT>
$(document).ready(function(){
	$("#login-form").submit();
});
</SCRIPT>
</HEAD>
<BODY>
<div style="display:none">
<FORM style="visibility:false" id="login-form" method="post" name="login" action="https://console.oray.com/passport/login?url=https%3A%2F%2Fconsole.oray.com%2Fsunlogin%2Fremote%2F">
<INPUT value="/" type="hidden" name="url"> 
<INPUT style="IME-MODE: disabled" value="<?=$username?>" id="account" type="text" name="account"> <br>
<INPUT id="password" type="password" value="<?=$password?>" name="password"><br>
<INPUT id="cookies" value="1" CHECKED type="checkbox" name="cookie"><br>
<BUTTON type="submit">登 陆</BUTTON>
</FORM>
</div>
</BODY>