<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>
本地搜索
</title>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=46ce9d0614bf7aefe0ba562f8cf87194&v=1.1&services=true">
</script>
<style>
body
{
	font-size:10px;
}
#container
{
	margin: 0px auto;
}
#map
{
	float:left;
	width:800px;
	height:600px;
	border:1px solid gray
}
#searchresult
{
	height:600px;
}
</style>
</head>
<body>
<div id="container">
	<div id="map"></div>
	<div id="searchresult"></div>
	<div id="transitresult"></div>
</div>
</body>
</html>
<script type="text/javascript">

var map = new BMap.Map("map");
map.centerAndZoom(new BMap.Point(118.515882,31.688528), 14);
map.enableScrollWheelZoom();                  // 启用滚轮放大缩小。
map.enableKeyboard();                         // 启用键盘操作。

/*
var local = new BMap.LocalSearch("马鞍山", 
	{ 
		renderOptions:
		{
			map: map,
			panel: "searchresult"
		},
		pageCapacity:50
	}
);


//local.search("解放路");

/*
var transit = new BMap.TransitRoute(map, {
  renderOptions: {map: map}
});
transit.search("火车站", "安徽工业大学");
*/ 

var transit = new BMap.TransitRoute(map,
{
  renderOptions: {map: map, panel: "searchresult"}
});
transit.search("市商业步行街", "安徽工业大学");
</script>

