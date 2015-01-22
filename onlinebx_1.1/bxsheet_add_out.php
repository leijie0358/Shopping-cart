<?
$url = "http://".$_SERVER["SERVER_NAME"].($_SERVER["SERVER_PORT"]==80?"":(":".$_SERVER["SERVER_PORT"]))."".$_SERVER["SCRIPT_NAME"];
$url = str_replace("bxsheet_add_out.php","",$url); 
?>

document.write('<link rel="stylesheet" href="<?=$url?>application/views/scripts/jqueryplugins/jqueryui/development-bundle/themes/base/jquery.ui.all.css" />');
function loadStyle(link,callback) {
	var HEAD = document.getElementsByTagName("head").item(0) || document.documentElement;

	var s = document.createElement("link");
	s.setAttribute("type","text/css");
	s.setAttribute("rel","stylesheet");
	s.onload = s.onreadystatechange = function() 
	{ 
		if(!/*@cc_on!@*/0 || this.readyState == "loaded" || this.readyState == "complete") 
		{
			if(typeof(callback) == "function") 
			{
				callback();
			}
		}
	}
	s.setAttribute("src",script);
	HEAD.appendChild(s);
}


function loadScript(script,callback) {
	var HEAD = document.getElementsByTagName("head").item(0) || document.documentElement;

	var s = document.createElement("script");
	s.setAttribute("type","text/javascript");
	s.onload = s.onreadystatechange = function() 
	{ 
		if(!/*@cc_on!@*/0 || this.readyState == "loaded" || this.readyState == "complete")              
		{
			if(typeof(callback) == "function") 
			{
				callback();
			}
		}
	}
	s.setAttribute("src",script);
	HEAD.appendChild(s);
}

function show_bxsheet(selector)
{
	var script = "<?=$url?>application/views/scripts/jquery-1.5.1.js" ;
	loadScript(script,function(){
		$(document).ready(function(){ 
			$(''+selector).load('index.php/bxsheet/outadd',null,function(){
				$('' + selector + ' td').css('font-size','12px');
				$('' + selector + ' #bx_date').css('width','80px');
				$('' + selector + ' #hope_wx_date_begin').css('width','80px');
				$('' + selector + ' #hope_wx_date_end').css('width','80px');
			});
		});
	});
}



