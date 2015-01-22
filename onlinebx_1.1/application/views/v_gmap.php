<script src="http://ditu.google.cn/maps?file=api&amp;v=2&amp;key=<?=$gmap_key?>&hl=zh-CN" type="text/javascript"></script> 

<style>
	#map_canvas
	{
		margin:0px auto;
		border:1px solid #aaaaaa;
		width: 780px; 
		height: 540px;
		float:left
	}

	#map_container
	{
		margin:0px auto;
		width:780px;
		float:left;
		margin-top:2px;
	}

	#map_customer_list
	{
		border:0px solid black;
		margin-left:6px;
		float:right;
		z-index:999;
		position:absolute; 
		width:240px;
		background-color:white;
	}

	#map_operate_container
	{
		height:470px;
		OVERFLOW-y:auto;
		overflow-x:hidden;
		border:1px dotted #aaaaaa;
		border-top  :0px; 
		border-bottom  :0px
	}

	.hand
	{
		cursor:pointer; 
	}

	#gmap_form
	{
		padding:20px 20px 20px 20px;
		font-size:12px; 
		line-height:40px;
	}
</style>

<script type="text/javascript"> 
    
	var map;
	var currentLevel = 14;
	
    var lastmarker = null;
	var mc_pos = {left:0,top:0};

	function showAddress(address) {  
		if(lastmarker != null)
			lastmarker.hide();

		var geocoder = new GClientGeocoder();
		geocoder.getLatLng(  
			address,  
			function(point) {  
				if (!point) {  
					alert(address + "没有找到"); 
					// 设置中心坐标点
					map.setCenter(new GLatLng(<?=$lat?>, <?=$lng?>), currentLevel);
				} else {  
					map.setCenter(point, currentLevel);  
					var marker = new GMarker(point);  
					map.addOverlay(marker);  
					marker.openInfoWindowHtml(address);  
					lastmarker =   marker  ; 
				}  
			}  
		);  
	}  

    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));

		// 设置事件
		GEvent.addListener(map, "zoomend", function(oldLevel,newLevel) {
			currentLevel = newLevel;
		});
		// 平滑缩放
		map.enableContinuousZoom();
		// 滚轮缩放
		map.enableScrollWheelZoom();
		// 启用搜索控件 
		//map.enableGoogleBar(); 
		// 设置中心坐标点
        map.setCenter(new GLatLng(<?=$lat?>, <?=$lng?>), currentLevel - 2); 

      }
    } 
 

	$(document).ready(function(){


		$("#map_operate_expand").click(function(){
			// alert('abc');
			$("#map_operate_container").animate({ 
				height: 'toggle', 
				opacity: 'toggle'
			}, 'normal' ); 

			$(this).text($(this).text()=="收起"?"展开":"收起") ; 
		});


		initialize();
		mc_pos = $('#map_canvas').offset();
		// alert(mc_pos.left);
		$('#map_customer_list').css('left', mc_pos.left + 320);
		$('#map_customer_list').css('top', mc_pos.top);

		$('.map_custom_latlng').click(function(){
			$('#map_canvas img').css('cursor','pointer');
			lat = $(this).attr('lat');
			lng = $(this).attr('lng');
			if(lat=="" || lng=="") 
			{
				alert('还没有标注，无法定位');
				return; 
			}
			
			point = new GLatLng(lat, lng);
			//var point = {lat,lng};
			map.setCenter(point,currentLevel);   
			if(lastmarker!=null)
			{
				//alert('abc');
				lastmarker.hide(); 
			}
			var marker = new GMarker(point);
			map.addOverlay(marker);  
			marker.openInfoWindowHtml("<b style='font-size:+2'>"+$(this).attr('t')+"</b><br>简要说明:"+$(this).attr('p')+"<br>公交站牌:" + $(this).attr('ts') + "<div style='width:200px;text-align:right;margin-right:6px'>&nbsp;</div>");  
			lastmarker = marker; 
		});
		$('.map_mark').click(function(){
			map_mark = $(this);
			$('#map_canvas img').css('cursor','crosshair');
			GEvent.addListener(
				map, 
				'click', 
				function(overlay, latlng) 
				{ 
					//alert(mc_pos.left+"-"+mc_pos.top);
					var lat= latlng.lat(); 
					var lng= latlng.lng();
					//alert(lat + "-" + lon);
					$('#lat').val(lat);
					$('#lng').val(lng); 
					$('#user_id').val(map_mark.attr('cid')); 
					win1 = jm_window.show({
						left:(mc_pos.left + (280 - 200)),
						top:(mc_pos.top + 50) ,  
						title:"标注位置",
						width: 400,
						body:'gmap_form',
						modal:true,
						button:jm_buttons.YesOrNo,
						yestext:'确定',
						notext:'取消',
						yes:function(){
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
							$('#latlngform').ajaxSubmit(options);
							return false;
						},
						no:function(){
							// alert('no'); 
						} 
					});
				}
			);
		});
	});
</script> 


<div id="map_container">
	<div id="map_canvas"></div> 
	
	<div id="map_customer_list"> 
		<table style="width:100%;border:1px dotted #aaaaaa;border-bottom:0px" >
			<tr><td colspan="2" style="text-align:right;cursor:pointer; border-bottom:1px dotted #aaaaaa">
				<font id="map_operate_expand">收起</td>
			</td></tr>
		</table>
		<div id="map_operate_container">
		<table>
			<? foreach($customs as $custom){?>
			<tr>
				<td width="185"><div class="map_custom_name">+ <?=$custom->company."-".$custom->realname?></div></td>
				<td><div cid="<?=$custom->id?>" class="map_mark hand">新增</div></td>
			</tr>
					<?
					$sql = "select * from latlng where user_id=".$custom->id;
					$latlngs = $this->db->query($sql)->result();
					foreach($latlngs as $latlng){
					?>
			<tr>
				<td><div  lat="<?=$latlng->lat?>" lng="<?=$latlng->lng?>" t="<?=$custom->company."-".$custom->realname."-".$latlng->title?>" p="<?=$latlng->profile?>" ts="<?=$latlng->transit_station?>" class="map_custom_latlng hand">&nbsp;&nbsp;- <?=$latlng->title?></div></td>
				<td>
					<a href="<?=$root_url?>index.php/gmap/delete/<?=$latlng->id?>">删除</a>
				</td>
			</tr>
					<?}?>
			<?}?>
			
		</table>
		</div>
		<table style="width:100%;border:1px dotted #aaaaaa;border-top:0px" >
			<tr><td colspan="2" style="border-top:1px dotted #aaaaaa">
				关键词 : <input type="text" size="17" id="address" /> 
				<input type="button" onclick="showAddress(document.getElementById('address').value)" value="搜索" />
			</td></tr>
		</table>
	</div> 

	<!--div style="float:right;padding-left:3px;width:206px;">
		<br />
		这只是一个试鲜版， 在IE6下，排板还有问题，另外还没有美化。缺少一些功能<br />
		<a href="<?=$root_url?>map.swf" target="_blank" style="font-size:14px;color:red">操作演示请点这里</a>
	</div-->
</div>
   
<div id="gmap_form" style="display:none">
	<form action="<?=$action?>" method="post" id="latlngform">
		<input type = "hidden" name = "lat" id ="lat" />
		<input type = "hidden" name = "lng" id ="lng" />
		<input type = "hidden" name = "user_id" id ="user_id" />    
		标注标题 : <input type = "text" name="title" /> <br>
		简要说明 : <input type = "text" name="profile" /><br>
		公交站牌 : <input type = "text" name="transit_station" /><br>
	</form> 
</div>            