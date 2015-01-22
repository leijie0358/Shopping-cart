<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8"/>
	<title><?=$title?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/style.css" />
	<?if($url != null){?>
	<meta http-equiv="Refresh" content="3;URL=<?=$url?>" />
	<?}?>
	<style>
	#b
	{
		margin:2px auto;
		border:1px solid #aaaaaa;
		width:300px;
		height:200px;
		padding:10px 10px 10px 10px ;
	}
	</style>
</head>
<body>
	<div id="container">
		<div id="b">
		<?=$title?>
		<hr width="100%" />
		<?=$errinfo?><br>
		<!--三秒后转向上一页面--> 
		</body>
	</div>
</body>
</html>