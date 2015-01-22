<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html>
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8"/>
	<title><?=$title?>报修单</title>
	<style>
	body
	{
		font: 1em "Trebuchet MS", verdana, arial, sans-serif;
		font-size:15px;
		margin: 10px 20px 10px 20px;
		text-align:center;
		padding: 0;
	}

	#container
	{
		margin:0 auto;
		width:800px;
		position:relative;
	}

	#controlarea
	{
		text-align:left;
	}

	#sperateline
	{
		width:100%;
		size:1px;
		background-color:black;
		margin-top:6px;
		margin-bottom:6px;
	}

	#tableheader
	{
		width:100%;
		margin:0px auto;
		padding:6px auto;
		font-size:24px;
		font-weight:bold;
		padding-top:16px;
	}
	
	#tablebody
	{
		text-align:left;
	}

	</style>

	<script type="text/javascript" src="<?=$root_url?>application/views/jquery-1.7.0.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#print").click(function(){
				$("#controlarea")[0].style.display = "none";
				window.print();
				$("#controlarea")[0].style.display = "block";
			});
		});

	</script>
</head>
<body>
	<div id="container">
		<div id="controlarea">
			<input type="button" value ="打印" id="print" />
		</div>
		<div id="printarea">
			<div id="tableheader"><?=$tableheader?>
			</div> 
			<hr id="sperateline"></hr>
			<div id="tablebody">
			<?=$tablebody?>
			</div>
			<div id="tablefooter">
			</div>
		</div>
	</div>
</body>
</html>