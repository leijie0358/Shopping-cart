<html>
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8"/>
	<title><?=$title?></title>
	<style>
	body
	{
		font-size: .75em;
		font-family: Verdana, Helvetica, Sans-Serif;
		margin: 10px 20px 10px 20px;
		text-align:center;
		padding: 0;
		color: #696969;
	}

	#container
	{
		width:800px;
		position:relative;
		text-align:left;
	}

	#header
	{
		padding:0px 0px 2px 0px;
	}
	
	#logo
	{
	}

	#menu
	{
	}
	
	#content
	{
		clear:both;
		float:left;
	}
		
	#sidebar
	{
		width:200px;
		float:right;
	}
	#footer
	{
		clear:both;
		text-align:center;
	}

	</style>
	<LINK rel="stylesheet" type="text/css" href="http://www.alistapart.com/d/sprites2/examples/example-script.css" media="screen">

	<link type="text/css" rel="stylesheet" href="application/views/scripts/jqueryplugins/potatomenu/jquery.ui.potato.menu.css" />
	<script type="text/javascript" src="application/views/scripts/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="application/views/scripts/jqueryplugins/potatomenu/jquery.ui.potato.menu.js"></script>
	<SCRIPT type="text/javascript"  src="http://www.alistapart.com/d/sprites2/examples/sprites2.js"></SCRIPT>


	<script type="text/javascript">
		$(document).ready(function(){
			// generateSprites arguments: 
			// 1st - parent class (the main class on the parent ul), with preceding period
			// 2nd - selected prefix (eg. for a selected class of "selected-about", use "selected-" as the value)
			// 3rd - :active state toggle, set to true if you've defined :active states (and the jQuery equivalent) in your CSS
			// 4th - animation speed, in milliseconds (eg. 300 = 0.3 seconds)
			// 5th - animation style, as a string. Set to "slide" or "fade" (defaults to "fade")
			
			// example usage:
			// generateSprites(".navigation", "selected-", true, 300, "fade");
			// generateSprites(".top-nav", "position-", true, 200, "slide");
			// generateSprites(".sidebar-nav", "current-", false, 150, "fade");
			generateSprites(".nav", "current-", true, 0, "slide");
		});

	</script>
	<!--<script type="text/javascript" src="application/views/scripts/jquery.u.menu.js"></script>-->
</head>
<body>
	<div id="container">
		<div id="header">
			<div id="logo">logo</div>
			<div id="menu">
				<ul class="nav current-about">
					<li class="home">
						<a  href="http://www.alistapart.com/d/sprites2/examples/example6-function.html#">Home</a>
					</li>
					<li class="about">
						<a href="http://www.alistapart.com/d/sprites2/examples/example6-function.html#">About</a>
					</li>
					<li class="services">
						<a href="http://www.alistapart.com/d/sprites2/examples/example6-function.html#">Services</a>
					</li>
					<li class="contact">
						<a href="http://www.alistapart.com/d/sprites2/examples/example6-function.html#">Contact</a>
					</li>
				</ul>
			</div>
		</div>
		<div id="pagebody">
			<div id="content"><?=$content?></div>
			<div id="sidebar"><?=$sidebar?></div>
		</div>
		<div id="footer">Power by <a href="http://www.ctrip.com" target="_blank">携程软件</a> </div>
	</div>
</body>
</html>