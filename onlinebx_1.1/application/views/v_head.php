<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8"/>

	<title><?php $sys = $this->config->item('sys');echo $sys["company_name"];?>--<?=$title?></title>
	<link rel="shortcut icon" href="images/html.ico" type="image/x-icon"/>
	<link href="bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/style.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/applegallery/style.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/applesidemenu/style.css" /> 



	<script type="text/javascript" src="<?=$root_url?>application/views/jquery-1.7.0.min.js"></script>
	<script type="text/javascript" src="<?=$root_url?>application/views/bootstrap.js" type="text/javascript"></script>

	<!------------jquery.accordion 左边栏------------------------->
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jquery.dimensions.js" type="text/javascript"></script> <!---jquery.accordion 依赖这个-->
    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/applesidemenu/jquery.accordion.js" type="text/javascript"></script> 

	<!------------jm_window  ajax 弹出窗口-------------------------->
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/jmwindow/jmwindow.css" /> 
    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/jmwindow/jmwindow.js" type="text/javascript"></script> 
	
	<!------------- 提交表单 ---------------------------------------->
    <script src="<?=$root_url?>application/views/scripts/jqueryplugins/jquery.form.js" type="text/javascript"></script> 

	<!------------jquery ui---------------------------------------->
	<link rel="stylesheet" href="<?=$root_url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/themes/base/jquery.ui.all.css" />
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
	
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jr_datatable/jr_datatable.js"></script>  	
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/jr_datatable/style.css" /> 
	
	<script src="<?=$root_url?>application/views/scripts/jqueryplugins/flexgrid/js/flexigrid.js"></script>  	
	<link rel="stylesheet" type="text/css" media="all" href="<?=$root_url?>application/views/scripts/jqueryplugins/flexgrid/css/flexigrid.css" />        
	<link href="<?=$root_url?>application/views/select2.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="<?=$root_url?>application/views/select2.js"></script>	
	<script type="text/javascript">

		function open_help(md)
		{
			var url = "<?=$root_url?>help/help.htm"; 
			if(md != "")
			{
				url += "#" + md;
			}
			//alert("abc");
			window.open(url,"name","height=600,width=660px,menubar=no,status=no,toolbar=no,scrollbars=yes",""); 
		}

		/********************************************  左侧菜单栏********************************/
		
		function set_form_style()
		{
			///*
			// 设置INPUT TYPE='TEXT'的样式
			$("input[type='text'],textarea,select").css('border','1px solid #7F9DB9'); 
			$("input[type='text']").css('height','20px');
			$("input[type='text']").css('line-height','20px');
			$("input[type='text']").css('padding-left','3px');
			$("input[type='text']").css('padding-right','3px'); 
			
			$("select").css('border','1px solid #7F9DB9');
			$("select").css('height','22px');
			$("select").css('line-height','22px');
			//$("select").css('margin-left','-1px');
			// $("textarea").css('border','1px solid #7F9DB9'); 
			//*/
			//$('form').addClass('niceform');
		}

		$(function () {
			$('ul.drawers').accordion({
				header: 'H2.drawer-handle',
				selectedClass: 'open',
				event: 'mouseover', 
				navigation: true,
				autoheight:true, 
				fillSpace:300
			});
		});


		/******************************  设置表格的样式(flexigrid 在IE下速度太慢,不如使用 .databale  **************/

		$(document).ready(function(){
			var db_grid_type = '<?=$this->session->userdata("db_grid_type")?>';
			
			if(db_grid_type == "datatable")
			{
				$('.flexi_grid').addClass('datatable'); 
				$('.flexi_grid').removeClass('flexi_grid'); 

				// user 不使用快速样式 
				$('#user').removeClass('datatable'); 
				$('#user').addClass('flexi_grid');  
			}

//			set_form_style() ; 
		});


		/***************************** 通用函数 **************************************************************/
		function getBrowser()
		{
			browser = {name:'',version:''};
			var browser_name = navigator.appName;
			if(browser_name == "Microsoft Internet Explorer")
			{
				browser.name = "IE";
				var xr = navigator.appVersion.split(";");
				version = xr[1];
				
				version = xr[1].split(" ");
				version = parseFloat(version[2]);
				
				browser.version = version;
			} 
			else
			{
				browser.name = "other";
			}

			return browser;
		}

		/*****************************************  flexigrid ********************************************/ 
		function flexi_grid(p)
		{
			p = $.extend({
					useRp: false,
					resizable: false,
					width:780 ,
					height:459,
					singleSelect:true
				},p);

			$('.flexi_grid').flexigrid(p);  
			
			fgrid_exbtns = $('.flexi_grid .fgrid_expand_button');
			fgrid_exbtns.each(function(btn_index){ 
				$(this).click(function(e){
					pos = $(this).offset();
					//alert(pos.left + "-" + pos.top);
					btn = $(this);
					$(".fgrid_opebtn_container").each(function(div_index){
						// alert(btn_index);
						if(div_index == btn_index)
						{
							$(this).appendTo($('body'));
							$(this).css('position','absolute');
							$(this).css('z-index','10');
							width =	$(this).width();
							$(this).css('left',pos.left - width -12);
							$(this).css('top',pos.top-5);

							btn_val = btn.val();
							// alert(display) ;   
							if(btn_val == "展开")
							{
								$(this).css('display','');
								btn.val('收起');
								$(this).css('opacity',0);
								$(this).animate({opacity:1},'slow');
							}
							else
							{
								$(this).animate({opacity:0},'slow');
								$(this).css('display','none');
								btn.val('展开');
							}
							
						}
						else  
						{
							$(this).css('display','none'); 
							fgrid_exbtns.eq(div_index).val('展开');
						}
					});
				});
			});
		}


		$.ajaxSetup ({
			cache: false //关闭AJAX相应的缓存
		});


		/******************************************** 弹出窗口 *********************************/ 
		// windowName 容器的窗口 
		// title 窗口的标题
		// formppage 要加载的表单页(页面的地址)
		// formid 表单页中<form>元素的ID   用于找到form 元素,并自动完成提交
		// width 窗口的宽充
		// isajaxsubmit  是否使用ajax进行异步提交  默认 异步提交
		function showModel(windowName,title,formpage,formid,width,isajaxsubmit)
		{
			// alert("abc");
/*			if(width==null) width=600;
			if(isajaxsubmit == null) isajaxsubmit = true;   
			
			
			var win = null;
	
			screenh = 0;
			scrrenw = 0;
			if($.browser.msie)
			{
				screenh = document.compatMode == "CSS1Compat"? document.documentElement.clientHeight : document.body.clientHeight;
				screenw = document.compatMode == "CSS1Compat"? document.documentElement.clientWidth : document.body.clientWidth;
			}
			else 
			{

			}  
			var formcontatiner = $("#" + windowName + " div");
			formcontatiner.load(formpage,null,function(){
				//alert("abc");
				//alert(formcontatiner.html());
				//alert($('#w').text());
				height = formcontatiner.height();
				height = screenh - win.height();

				toptmp = height/2;
				if(toptmp>100) toptmp = 100;

				win.css("top",toptmp);

//				set_form_style() ; 
			});*/
				screenh = self.innerHeight;
				screenw = self.innerWidth;
			
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
			
			var btn = jm_buttons.YesOrNo;
			if(formid=="" || formid==null)
			{
				btn = jm_buttons.OK;
			}

			win = jm_window.show({
				left:(screenw-width)/2,
				//top:top,
				title:title,
				width: width,
				body:'w',
				modal:true,
				button:btn,
				oktext : '确定',
				yestext:'确定',
				notext:'取消',
				ok : function()
				{
				}, 
				yes:function(){
					/*
					if(formid=="" || formid==null)
					{
						jm_window.close();
						return false;
					}
					*/
					$(document).ready(function(){
						// alert(formid);
						//jm_window.close();
						// 假如非异步提交直接使用 submit 进行同步提交  
						if(!isajaxsubmit)  
						{
							//alert("abc");return false;
							$('#' + formid).submit();
							return false;
						}
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
			<div id="logo">
				<div style="float:left">
					<? $sys = $this->config->item('sys');echo $sys["company_name"];?>-在线报修系统
				</div>
				<div style='float:right;padding-right:20px;'>
					用户：<?=preg_replace('|[a-z/]+|','',$_SESSION['phpCAS']['attributes']['sn'])?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="javascript:void(0)"  style='color:white;padding:0px;'
					onclick="showModel('w','帮助文档下载','<?=$root_url?>index.php/welcome/help_download/','',280)"> 
						帮助文档
					</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="javascript:void(0)"  style='color:white;padding:0px;'
					onclick="showModel('w','修改密码','<?=$root_url?>index.php/user/update_password/','update_passwordform',280)">
						修改密码
					</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="?logout=" style='color:white;padding:0px'>退出</a>
				</div>
			</div>
			<div style='clear:both'></div>
			<div id="adv">
				
			</div>
		</div>



	</div>
	
	
	<div id="w" style="display: none; background: #fafafa; cursor: default;">
		<div region="center" border="false" style="padding: 10px; background: #fff;">
			success!
		</div>
	</div>
</body>
</html>