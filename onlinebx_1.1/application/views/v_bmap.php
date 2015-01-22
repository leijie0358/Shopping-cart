<script type="text/javascript" src="http://api.map.baidu.com/api?key=46ce9d0614bf7aefe0ba562f8cf87194&v=1.1&services=true"></script>

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

	#map_operate_bar
	{
		width:260px;
		border:0px solid black;
		margin-left:6px;
		float:right;
		position:absolute; 
		background-color:white;
	}

	#map_slide_block
	{
		height:470px;
		OVERFLOW-y:auto;
		overflow-x:hidden;
		border:1px dotted #aaaaaa;
		border-top  :0px; 
		border-bottom  :0px
	}

	#map_customer_list 
	{
		height:270px ; 
	}

	#map_transit_result 
	{
		height:200px;
		OVERFLOW-y:auto;
		overflow-x:hidden;
		border:1px dotted #aaaaaa;
		border-top  :0px; 
		border-bottom  :0px;
		padding-left:6px;
		padding-right:3px;
	}

	.transit_line_title
	{
		font-size:14px;
		line-height:26px;
		font-weight:bold;
		background-color:#f1f2f3;
		cursor:pointer ;
	}

	.hand
	{
		cursor:pointer; 
	}

	#bmap_form
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

	var myIcon = null;
	var beginIcon = null;
	var endIcon = null; 

	var transit = null;
	var local = null ;   

	// alert('abc');

	function local_search(address) 
	{  
		if(address == "")
		{
			alert('关键字不能为空');
			return ; 
		}

		$('#map_transit_result').html('');
		   
		// 清除所有覆盖物
		map.clearOverlays(); 
		local.search(address); 
		
	}  

	
	var transit_search_results = null;

	function transit_search_complete(results){
		//alert(BMAP_STATUS_SUCCESS);
	  if (transit.getStatus() == BMAP_STATUS_SUCCESS){
	
		// 输出方案信息
		transit_search_results = results;
		$('#map_transit_result').html('');
		for (i = 0; i < results.getNumPlans(); i ++){
		  s = "<div class='transit_line_title' title='点击在地图上查看路线' ind='" + i + "'>第"+(i + 1)+"条线路(点击在地图上显示)</div>";
		  s+="<div>" + results.getPlan(i).getDescription() + "</div>";
			$(s).appendTo($('#map_transit_result'));
		}
		
		
		
		$('.transit_line_title').click(function(){
			var points = new Array();
			// 清除所有覆盖物
			map.clearOverlays();
			index = $(this).attr('ind');
			plan = transit_search_results.getPlan(index);

			// 绘制步行线路
			for (var i = 0; i < plan.getNumRoutes(); i ++)
			{
				var walk = plan.getRoute(i);
				
				if (walk.getDistance(false) > 0)
				{
					polyLine = new BMap.Polyline(walk.getPoints(), {strokeColor: "red"});
					polyLine.setStrokeStyle('dashed');
					// 步行线路有可能为0
					map.addOverlay(polyLine);
				}
			}
			// 绘制公交线路
			for (i = 0; i < plan.getNumLines(); i ++)
			{
				var line = plan.getLine(i);
				map.addOverlay(new BMap.Polyline(line.getPoints()));
			}
			
			
			bPoint = transit_search_results.getStart().point;
			var bmarker = new BMap.Marker(bPoint, {icon: beginIcon});
			map.addOverlay(bmarker);

			ePoint = transit_search_results.getEnd().point;
			var emarker = new BMap.Marker(ePoint, {icon: endIcon});
			map.addOverlay(emarker);

			//map.setViewport(points);

		});

	  }
	  else
		{
		  $('#map_transit_result').html('没有查到公交信息');
		}
	}
    function initialize() {
		map = new BMap.Map("map_canvas")
		
		myIcon = new BMap.Icon( "<?=$root_url?>application/views/images/custom_a_j.png",new BMap.Size(35, 40),
		{
			offset: new BMap.Size(18, 20)
			//imageOffset: new BMap.Size(-16, 0)
		});

		beginIcon = new BMap.Icon( "<?=$root_url?>application/views/images/dest_markers.png",new BMap.Size(35, 40),
		{
			offset: new BMap.Size(18, 20)
		});

		endIcon = new BMap.Icon( "<?=$root_url?>application/views/images/dest_markers.png",new BMap.Size(35, 40),
		{
			offset: new BMap.Size(18, 20),
			imageOffset: new BMap.Size(0, -33)
		});

		// 设置事件
		map.addEventListener("zoomend", function() {
			currentLevel = this.getZoom() ; 
		});
		// 滚轮缩放
		map.enableScrollWheelZoom();
		map.enableKeyboard();   // 键盘操作 
		// 启用搜索控件 
		//map.enableGoogleBar(); 

		var point = new BMap.Point(<?=$lng?>,<?=$lat?>);    // 创建点坐标
		map.centerAndZoom(point,currentLevel);     // 初始化地图,设置中心点坐标和地图级别。

		// 配置公交 搜索 
		transit = new BMap.TransitRoute(map);
		transit.setSearchCompleteCallback(transit_search_complete);

		// 配置本地搜索
		local = new BMap.LocalSearch(map, {
		  renderOptions: {map: map, panel: "map_transit_result"},
		  onResultsHtmlSet : function(){
			//html = $('#map_transit_result').html();
			//var reg = new RegExp("更多结果»","g"); //创建正则RegExp对象   
			//html = html.replace(reg,"&nbsp;");   
			//$('#map_transit_result').html(html);

			//$('#map_transit_result li span').css('text-decoration','none');
			//$('#map_transit_result li span').css('color','#888888');
				  

			$("a[title='到百度地图查看更多结果']").html('携程软件');
			
			$("a[title='到百度地图查看更多结果']").attr('href','http://www.ctrip.com');
			$("a[title='到百度地图查看更多结果']").attr('title','携程软件,一路助你');   
		  }
		});

		mc_pos = $('#map_canvas').offset();
		mc_width= parseFloat($('#map_canvas').css('width'));
		bar_width = parseFloat($('#map_operate_bar').css('width'));
		// alert(bar_width);
		//alert(mc_pos.left);
		// 定位标注窗口
		$('#map_operate_bar').css(
			'left', 
			mc_pos.left + mc_width - bar_width - 220
		);
		$('#map_operate_bar').css('top', mc_pos.top);
		//$('#map_operate_bar').css('left', 100);
		//$('#map_operate_bar').css('top', 100);
    } 
 
	function pos(){
		
		map.clearOverlays();
		map.removeEventListener("click", mark);
		$('#map_canvas div').css('cursor','pointer');
		lat = $(this).attr('lat');
		lng = $(this).attr('lng');
		if(lat=="" || lng=="") 
		{
			alert('还没有标注，无法定位');
			return; 
		}
		
		var point = new BMap.Point(lng, lat);    // 创建点坐标
		map.centerAndZoom(point,currentLevel);     // 初始化地图,设置中心点坐标和地图级别。

		
		company = $(this).attr('c');
		realname = $(this).attr('r');
		title = $(this).attr('t') ;
		profile = $(this).attr('p');
		transit_station = $(this).attr('ts');
		lid = $(this).attr('lid');
		create_InfoWindow(lid,lat,lng,company,realname,title,profile,transit_station);
		// lastmarker = marker; 
	}
		
	function search_transit()
	{
		tar_ts = $(this).attr('ts');
		if(tar_ts=="")
		{
			alert('没有设置公交站牌，无法进行操作');
		}
		
		cts = $("#company_transit_station").find('option:selected').text();
		// alert(cts);
		transit.search(cts,tar_ts);
	}

	function mark(p)    
	{      
		//alert(mc_pos.left+"-"+mc_pos.top);
		$("input[name='title']").val('');
		$("input[name='profile']").val('');
		$("input[name='transit_station']").val('');
		latlng = p.point;
		var lat= latlng.lat; 
		var lng= latlng.lng;
		//alert(lat + "-" + lon);
		$('#lat').val(lat);
		$('#lng').val(lng); 
		$('#company').val(map_mark.attr('c')); 
		$('#realname').val(map_mark.attr('r')); 
		$('#user_id').val(map_mark.attr('cid')); 
		win1 = jm_window.show({
			left:(mc_pos.left + (280 - 200)),
			top:(mc_pos.top + 50) ,  
			title:"标注位置",
			width: 400,
			body:'bmap_form',   
			modal:true,
			button:jm_buttons.YesOrNo,
			yestext:'确定',
			notext:'取消',
			yes:function(){
				var options = { 
					beforeSubmit:  function(){

					},  // pre-submit callback 
					success:       function(data){
						
						if(data.split('-')[0] == "success_jr_soft")
						{
							latlng_id = data.split('-')[1] ;  
							   
							
							title = $("input[name='title']").val();
							profile = $("input[name='profile']").val();
							transit_station = $("input[name='transit_station']").val();
							lng = $('#lng').val();
							lat = $('#lat').val();
							user_id =  $('#user_id').val();
							company =  $('#company').val();
							realname =  $('#realname').val();
							
							// alert(user_id+"-"+company+"-"+realname);

							// 创建一个信息窗口
							create_InfoWindow(latlng_id,lat,lng,company,realname,title,profile,transit_station);
							
							latlngs_classname = user_id + "_items";
							//alert('.' + latlngs_classname);
							
							last_latlng = $('.' + latlngs_classname).last();
							//alert(latlng_first);

							new_latlng = "<tr class='" + user_id + 
								"_items'><td><div lid='" + latlng_id + "' lat='" + lat + "' lng='" + lng + "' c='" + company + "' r='" + realname + 
								"' t='" + title + "' p='" + profile + 
								"' ts='" + transit_station + "' class='map_custom_latlng hand'>&nbsp;&nbsp;- " + title + 
								"(<a ts='" + transit_station + "' class='map_ts_btn'>公交</a>)" +
								" </div></td><td><a href='<?=$root_url?>index.php/bmap/delete/" + latlng_id + "'>删除</a></td></tr>";
							

							
								
							//$(new_latlng).appendTo($('#bcd'));
							//alert(new_latlng.html());
							$(new_latlng).insertAfter(last_latlng);
							
							// 定位
						    $('.map_custom_latlng').click(pos);

							$('.map_ts_btn').click(search_transit);

							jm_window.close() ;    
						}
						else
						{
							alert(data);
						}
					}  // post-submit callback 

				}; 
				$('#latlngform').attr('action','<?=$root_url?>index.php/bmap/mark');
				$('#latlngform').ajaxSubmit(options);
				return false;
			},
			no:function(){
				// alert('no'); 
			} 
		});
	}
	
	function edit_mark(latlng_id,title,profile,transit_station)
	{
		//alert(title+"-"+profile+"-"+transit_station);

		$("input[name='title']").val(title);
		$("input[name='profile']").val(profile);
		$("input[name='transit_station']").val(transit_station);

		win1 = jm_window.show({
			left:(mc_pos.left + (280 - 200)),
			top:(mc_pos.top + 50) ,  
			title:"标注位置",
			width: 400,
			body:'bmap_form',   
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
							latlng = $("div[lid='" + latlng_id + "']");

							title = $("input[name='title']").val();
							profile = $("input[name='profile']").val();
							transit_station = $("input[name='transit_station']").val();
							lng =latlng.attr('lng');
							lat = latlng.attr('lat');
							user_id =  $('#user_id').val();
							company =  $('#company').val();
							realname =  $('#realname').val();
							
							// alert(user_id+"-"+company+"-"+realname);

							// 创建一个信息窗口
							create_InfoWindow(latlng_id,lat,lng,company,realname,title,profile,transit_station);
							
							//alert('.' + latlngs_classname);
							
							latlng.attr('t',title);
							latlng.attr('p',profile);
							latlng.attr('ts',transit_station);
							latlng.html("&nbsp;&nbsp;- " + title + 
								"(<a ts='" + transit_station + "' class='map_ts_btn'>公交</a>)");  
							// 定位
						    $('.map_custom_latlng').click(pos);

							$('.map_ts_btn').click(search_transit);

							jm_window.close() ;    
						}
						else
						{
							alert(data);
						}
					}  // post-submit callback 

				}; 
				$('#latlngform').attr('action','<?=$root_url?>index.php/bmap/edit/' + latlng_id);
				$('#latlngform').ajaxSubmit(options);
				return false;
			},
			no:function(){
				// alert('no'); 
			} 
		});
	}

	function  create_InfoWindow(latlng_id,lat,lng,company,realname,title,profile,transit_station)
	{
		if(lastmarker!=null)
			lastmarker.hide(); 

		sContent= "<b style='font-size:14px'>" + 
			company + "-" + realname + "-" + title +
			"</b><br>简要说明:" + 
			profile +
			"<br>公交站牌:" + 
			transit_station + 
			"<div style='width:200px;text-align:right;margin-right:6px' ><a href='javascript:void(0)' onclick=\"edit_mark('" + latlng_id + "','" + title + "','" + profile + "','" + transit_station + "')\" id='map_latlng_info_edit'>编辑</a></div>";

		// alert(sContent);
		point = new BMap.Point(lng, lat);
		var marker = new BMap.Marker(point, {icon: myIcon});
		var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
		map.addOverlay(marker);
		marker.openInfoWindow(infoWindow);
		lastmarker = marker; 

	}

	$(document).ready(function(){
		$("#map_operate_expand").click(function(){
			// alert('abc');
			$("#map_slide_block").animate({ 
				height: 'toggle', 
				opacity: 'toggle'
			}, 'normal' ); 
			
			$(this).html(($(this).html()=="收起&nbsp;&nbsp;&nbsp;&nbsp;")?"展开&nbsp;&nbsp;&nbsp;&nbsp;":"收起&nbsp;&nbsp;&nbsp;&nbsp;") ;    
		});
	
		initialize();

		// 定位
		$('.map_custom_latlng').click(pos);

		
		// 标注图标的单击事件
		$('.map_mark').click(function(){
			map_mark = $(this);
			$('#map_canvas div').css('cursor','crosshair');
			map.addEventListener(
				'click', 
				mark
			);
		});

		$('.map_ts_btn').click(search_transit);
		
		/*
		$('#map_local_search_btn').click(function(){
			key = $('#map_local_sarch_address').val();
			if(key == "")
			{
				 alert('关键字不能为空');
			}
			$('#map_transit_result ').html('');
			local.search(key);
		});
		*/

	});
</script> 

<div id="map_container">
	<div id="map_canvas"></div> 
	<div></div>
	<div id="map_operate_bar"> 
		<table style="width:100%;border:1px dotted #aaaaaa;border-bottom:0px;background-color:#95a0b2;color:white" >
			<tr><td colspan="2" style="text-align:right;cursor:pointer; border-bottom:1px dotted #aaaaaa;line-height:28px">
				起点站:
				<select id="company_transit_station" style="width:140px"> 
					<?foreach(explode(',',$company_transit_station) as $cts){?>
					<option value="<?=$cts?>"><?=$cts?></option> 
					<?}?>
				</select>&nbsp;
				<font id="map_operate_expand">收起&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</td></tr>
		</table>
		<div id="map_slide_block">
			<div id="map_customer_list">
			<table style="width:100%;">
				<? foreach($customs as $custom){?>
				<tr>
					<td><div class="map_custom_name">+ <?=$custom->company."-".$custom->realname?></div></td>
					<td width="40"><div cid="<?=$custom->id?>" c="<?=$custom->company?>" r="<?=$custom->realname?>" class="map_mark hand">新增</div></td>
				</tr>
						<?
						$sql = "select * from latlng where user_id=".$custom->id;
						$latlngs = $this->db->query($sql)->result();
						foreach($latlngs as $latlng){
						?>
				<tr class="<?=$custom->id?>_items">
					<td><div  lid="<?=$latlng->id?>" lat="<?=$latlng->lat?>" lng="<?=$latlng->lng?>" c="<?=$custom->company?>" r="<?=$custom->realname?>" t="<?=$latlng->title?>" p="<?=$latlng->profile?>" ts="<?=$latlng->transit_station?>" class="map_custom_latlng hand">&nbsp;&nbsp;- <?=$latlng->title?>&nbsp;(<a ts="<?=$latlng->transit_station?>" class="map_ts_btn">公交</a>)</div></td>
					<td>
						<a href="<?=$root_url?>index.php/bmap/delete/<?=$latlng->id?>">删除</a>
					</td>
				</tr>
						<?}?>
				<?}?>
				
			</table>
			</div>
			<div id="map_transit_result">
			 
			</div> 
		</div>
		
		<table style="width:100%;border:1px dotted #aaaaaa;border-top:0px" >
			<tr><td colspan="2" style="border-top:1px dotted #aaaaaa">
				关键词 : <input type="text" size="17" id="map_local_search_address" /> 
				<input type="button" id="map_local_search_btn" onclick="local_search(document.getElementById('map_local_search_address').value)" style="border:1px solid #aaaaaa" value="搜索" />
			</td></tr>
		</table>
	</div> 

	<!--div style="float:right;padding-left:3px;width:206px;">
		<br />
		这只是一个试鲜版， 在IE6下，排板还有问题，另外还没有美化。缺少一些功能<br />
		<a href="<?=$root_url?>map.swf" target="_blank" style="font-size:14px;color:red">操作演示请点这里</a>
	</div-->
</div>
   
<div id="bmap_form" style="display:none">
	<form action="<?=$action?>" method="post" id="latlngform">
		<input type = "hidden" name = "lat" id ="lat" />
		<input type = "hidden" name = "lng" id ="lng" />
		<input type = "hidden" name = "company" id ="company" />
		<input type = "hidden" name = "realname" id ="realname" /> 
		<input type = "hidden" name = "user_id" id ="user_id" />     
		标注标题 : <input type = "text" name="title" /> <br>
		简要说明 : <input type = "text" name="profile" /><br>
		公交站牌 : <input type = "text" name="transit_station" /><br>
	</form> 
</div>     

