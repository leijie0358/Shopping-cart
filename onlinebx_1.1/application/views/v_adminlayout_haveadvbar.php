<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8"/>
	<title><?=$title?></title>
	
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/style.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/applegallery/style.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/applesidemenu/style.css" /> 

	<style type="text/css">
		#advgallery{
			display:none;
		}
	</style>
	<!--[if lte IE 7]>
	<style type="text/css">
	#advgallery{
		display:none;
	}
	</style>
	<![endif]-->


	
	<!--[if lte IE 7]>
	<style type="text/css">
	ul li{
	display:inline;
	/*float:left;*/
	}
	</style>
	<![endif]-->

	

	<script type="text/javascript" src="<?=$root_url?>application/views/scripts/jquery-1.5.1.js"></script>
	<link rel="stylesheet" href="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/themes/base/jquery.ui.all.css"> 

	<!------------jquery.accordion 左边栏------------------------->
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/applesidemenu/jquery.dimensions.js" type="text/javascript"></script> 
    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/applesidemenu/jquery.accordion.js" type="text/javascript"></script> 

	<!------------jm_window  ajax 弹出窗口-------------------------->
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/jmwindow/jmwindow.css" /> 
    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/jmwindow/jmwindow.js" type="text/javascript"></script> 

    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/jquery.form.js" type="text/javascript"></script> 

	<!------------jquery ui---------------------------------------->
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.core.js"></script> 
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.widget.js"></script> 
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.datepicker.js"></script> 
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.mouse.js"></script>
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.autocomplete.js"></script>
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.dialog.js"></script> 
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.draggable.js"></script>
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.droppable.js"></script>  	
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/ui/jquery.ui.position.js"></script>

    <!--<script src="<?=$root_url?>application/views/scripts/jqueryplugins/applegallery/applegallery.js" type="text/javascript"></script>-->

   
    <script type="text/javascript">
		// 只有在IE8或者非IE浏览器时才执行广告处。
        var Sys = {};
        var ua = navigator.userAgent.toLowerCase();
        if (window.ActiveXObject)
            Sys.ie = ua.match(/msie ([\d.]+)/)[1] 
        else if (document.getBoxObjectFor)
            Sys.firefox = ua.match(/firefox\/([\d.]+)/)[1]
        else if (window.MessageEvent && !document.getBoxObjectFor)
            Sys.chrome = ua.match(/chrome\/([\d.]+)/)[1]
        else if (window.opera)
            Sys.opera = ua.match(/opera.([\d.]+)/)[1]
        else if (window.openDatabase)
            Sys.safari = ua.match(/version\/([\d.]+)/)[1];
        
        //以下进行测试
		/****    
        if(!Sys.ie || (Sys.ie && parseFloat(Sys.ie)>=10.0)) 
		{
			document.write("<script src=\"<?=$root_url?>application/views/scripts/jqueryplugins/applegallery/applegallery.js\" type=\"text/javascript\"><\/script> ");
		}
		*****/
        //if(Sys.firefox) document.write('Firefox: '+Sys.firefox);
        //if(Sys.chrome) document.write('Chrome: '+Sys.chrome);
        //if(Sys.opera) document.write('Opera: '+Sys.opera);
        //if(Sys.safari) document.write('Safari: '+Sys.safari);
    </script>

	<script type="text/javascript">
		$(function () {
			$('ul.drawers').accordion({
				header: 'H2.drawer-handle',
				selectedClass: 'open',
				event: 'mouseover',
				navigation: true
			});
		});

		$.ajaxSetup ({
			cache: false //关闭AJAX相应的缓存
		});

		function showModel(windowName,title,formpage,formid,width)
		{
			// alert("abc");
			if(width==null) width=600;
			
			var formcontatiner = $("#" + windowName + " div");
			
			var win = null;
			/***
			var top = (document.documentElement.clientHeight-tar.height())/2+document.documentElement.scrollTop+document.body.scrollTop;
			var left = (document.documentElement.clientWidth-width)/2+document.documentElement.scrollLeft+document.body.scrollLeft;

			tar.left = left;
			tar.top = top;
			***/

			screenh = 0;
			scrrenw = 0;
			if($.browser.msie){
				screenh = document.compatMode == "CSS1Compat"? document.documentElement.clientHeight : document.body.clientHeight;
				screenw = document.compatMode == "CSS1Compat"? document.documentElement.clientWidth : document.body.clientWidth;
			}
			else {
				screenh = self.innerHeight;
				screenw = self.innerWidth;
			}

			formcontatiner.load(formpage,null,function(){
				height = formcontatiner.height();
				
				height = screenh - win.height();

				toptmp = height/2;
				if(toptmp>100) toptmp = 100;

				win.css("top",toptmp);
			
			});

			
			if(formid.substring(0,5)=="show-")
			{
				win = jm_window.show({
					left:(screenw-width)/2,
					//top:top,
					title:title,
					width: width,
					body:'w',
					modal:true,
					button:jm_buttons.YesOrNo,
					yestext:'打印预览',
					notext:'取消',
					yes:function(){
						href = "<?=$root_url?>index.php/" + formid.split('-')[1] + "/iprint/" + formid.split('-')[2];
						win = window.open( href,"", "scrollbars=no,status=yes,resizable=no,top=0,left=0,width="+(screen.availWidth-10)+",height="+(screen.availHeight-30));
						win.focus();
					},
					no:function(){
						
					} 
				});

				return;
			}

			win = jm_window.show({
				left:(screenw-width)/2,
				//top:top,
				title:title,
				width: width,
				body:'w',
				modal:true,
				button:jm_buttons.YesOrNo,
				yestext:'确定',
				notext:'取消',
				yes:function(){
					$(document).ready(function(){
						//jm_window.close();
						var options = { 
							beforeSubmit:  function(){

							},  // pre-submit callback 
							success:       function(data){
								
								if(data == "success")
								{
									href = document.location.href;
									href = href.replace(/(^\s*)|(\s*$)/g, "");
									href = href.replace(/(#*$)/g, "");
									//alert(href);
									document.location.href = href;
								}
								else
								{
									alert(data);
								}
							}  // post-submit callback 
		
						}; 
						// alert($('#' + formid).attr("action"));
						$('#' + formid).ajaxSubmit(options);
						return false;
					});
				},
				no:function(){
					
				} 
			});
	
		}
	</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<div id="logo">在线报修系统</div>
			<div id="adv">
				<div id="advgallery">
					<!-- Begin DIV Slides-->
					<div id="slides">
						<div class="slide">
							<!--<img src="<?=$root_url?>application/views/images/sample_slides/macbook.jpg" alt="side" />-->
							<img src="<?=$root_url?>application/views/images/sample_slides/01.jpg" alt="thumbnail" />
						</div>
						<div class="slide">
							<!--<img src="<?=$root_url?>application/views/images/sample_slides/iphone.jpg" alt="side" />-->
							<img src="<?=$root_url?>application/views/images/sample_slides/02.jpg" alt="thumbnail" />
						</div>
						<div class="slide">
							<!--<img src="<?=$root_url?>application/views/images/sample_slides/imac.jpg" alt="side" />-->
							<img src="<?=$root_url?>application/views/images/sample_slides/03.jpg" alt="thumbnail" />
						</div>
						<!--<div class="slide">
							<img src="<?=$root_url?>application/views/images/sample_slides/info.jpg" alt="side" />
						</div>-->
					</div>  
					<!-- End DIV Slides-->
					<!-- Begin DIV AdvMenu-->
					<div id="advmenu">
						<ul>
							<li class="menuItem">
								<a href="">便&nbsp;&nbsp;捷
									<!--<img src="<?=$root_url?>application/views/images/sample_slides/thumb_macbook.png" alt="thumbnail" />-->
								</a>
							</li>
							<li class="menuItem">
								<a href="">高&nbsp;&nbsp;效
									<!--<img src="<?=$root_url?>application/views/images/sample_slides/thumb_iphone.png" alt="thumbnail" />-->
								</a>
							</li>
							<li class="menuItem">
								<a href="">性&nbsp;&nbsp;能
									<!--<img src="<?=$root_url?>application/views/images/sample_slides/thumb_imac.png" alt="thumbnail" />-->
								</a>
							</li>
							<!--<li class="menuItem">
								<a href="">
									<img src="<?=$root_url?>application/views/images/sample_slides/thumb_about.png" alt="thumbnail" />
								</a>
							</li>-->
						</ul>
					</div>
					<!-- End DIV AdvMenu-->
				</div>
			</div>
		</div>
		<div id="pagebody">
			<div id="sidebar">
				<div class="drawers-wrapper"> 
					<div class="boxcap captop"></div>
					<ul class="drawers">
						<?
						$ci = &get_instance(); 
						if ($ci->uri->segment(1) === FALSE)
						{
							$current_controller = "bxsheet";
						}
						else
						{
							$current_controller = $this->uri->segment(1);
						}

						$query = $ci->db->get_where("resource",array("parent_id" => 0));
						$top_resources = $query->result();
						$ci->load->library("autho");
						$user = $ci->session->userdata("user");

						foreach($top_resources as $top_resource)
						{
							$iscan = false;
							if($user->role_type==3)
							{
								$iscan = true;
							}
							else
							{
								$iscan = $ci->autho->isauth($user->role_id,$top_resource->id,"show");
							}
							if($iscan)
							{
					    ?>
						<li class="drawer">
							<h2 class="drawer-handle"><?=$top_resource->chinesename?></h2>
							<ul>
								<?
								$subquery = $ci->db->get_where("resource",array("parent_id" => $top_resource->id));
								$resources = $subquery->result();
								foreach($resources as $resource)
								{
									if($ci->autho->isauth($user->role_id,$resource->id,"index"))
									{
								?>
								<li><a href="<?=$root_url?>index.php/<?=$resource->name?>/index"><?=$resource->chinesename?></a></li> 
								<?
									}
								}
								
								?>
								<div class="drawercontentspace"></div>
							</ul>
						</li>
						<?
							}
						}
						?>
					</ul>
					<div class="boxcap"></div>
				</div> 
			</div>
			<div id="content">
				
				<ul id="breadcrumb">
					<li id="breadcrumb-home">
							<img src="<?=$root_url?>application/views/images/home.png" alt="Home" class="home" />
					</li>
					<li width="600px"></li>
				</ul>
				
				<?=$content?>
			
			</div>
		</div>
		<div id="line"></div>
		<div id="footer">
			© Copyright 2014 Ctrip Computer Technology (Beijing) Co., Ltd. All rights reserved.
		</div>

	</div>
</body>
</html>