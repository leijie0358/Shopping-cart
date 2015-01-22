<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html>
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8"/>
	<title></title>
	<style>
	#bxsheetform .custom
	{
		/*display:none;*/
	}
	</style>
	<script type="text/javascript" src="<?=$root_url?>application/views/scripts/jquery-1.5.1.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/outstyle.css" /> 
	<!------------- 提交表单 ---------------------------------------->
    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/jquery.form.js" type="text/javascript"></script> 

	<!------------jquery ui---------------------------------------->
	<link rel="stylesheet" href="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/themes/base/jquery.ui.all.css" />
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.core.js"></script> 
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.widget.js"></script> 
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.datepicker.js"></script> 

	
	<!------------- 浮动QQ面板 ---------------------------------------->
    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/jquery.float.panel.js" type="text/javascript"></script> 

	<script>
	$.ajaxSetup ({
		cache: false //关闭AJAX相应的缓存
	});

	$(document).ready(function(){
		$('#subm').click(function(){
			// alert('abc');
			var options = { 
					beforeSubmit:  function(){ 

					},
					success : function(data){
						if(data == "success")
						{
							alert("添加成功")
						}
						else
						{
							alert(data);
						}
					}
			}; 
			// alert($('#' + formid).attr("action"));
			$('#bxsheetform').ajaxSubmit(options);
		});

		$("#divQQPanelRight").toFloat({});
	});

	</script>
</head>
<body>
	<div id="container">
		<?=$content?>
		<input type="button" id="subm" value='提交' />
		<div id ="divQQPanelRight" style="position:absolute">abc</div>
	</div>
		
</body>
</html>