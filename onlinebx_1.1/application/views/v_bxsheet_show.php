<?php
//	require_once("/application/controllers/bxsheet.php");
	if(!strpos($_SERVER['PHP_SELF'],'iprint'))
		require_once 'v_head.php';
//	Bxsheet::index();
?>
<style>
.bxsheet_show
{
	border-bottom: 1px solid #666666;
}
.show td
{
	padding-top:6px;
	padding-bottom:6px;
}
</style>

<table class="show" align="center">
	<tr>
		<td width="90">
			报修编号
		</td>
		<td>
			<label class="bxsheet_show"><?=$number?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修部门
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_company?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			姓名
		</td>
		<td>
			<label class="bxsheet_show"><?=$custom_name?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			报修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=date("Y-m-d H:i",strtotime($bx_time))?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			维修地点 
		</td>
		<td>
			<label class="bxsheet_show">北京市朝阳区<?=$custom_addr_detail?>&nbsp;</label>
		</td>
	</tr>
	
	<tr>
		<td>
			工作电话	
		</td>
		<td>
			<div class="bxsheet_show"><?=$custom_workphone?>&nbsp;</div>
		</td>
	</tr>
	
	<tr>
		<td>
			手机	
		</td>
		<td>
			<div class="bxsheet_show"><?=$custom_mobilephone?>&nbsp;</div>
		</td>
	</tr>

	<tr>
		<td>
			希望维修时间
		</td>
		<td>
			<label class="bxsheet_show"><?=date("Y-m-d H:i",strtotime($hope_wx_time_begin))?> -- <?=date("Y-m-d H:i",strtotime($hope_wx_time_end))?>&nbsp;</label>
		</td>
	</tr>
	<tr>
		<td>
			故障类别
		</td>
		<td>
			<div class="bxsheet_show"><?=$bxsheet_class_name?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			报修名称
		</td>
		<td>
			<div class="bxsheet_show"><?=$fault_title?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			故障现象
		</td>
		<td>
			<div class="bxsheet_show"><?=$fault_profile?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			处理结果
		</td>
		<td>
			<div class="bxsheet_show"><?=$result?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			签收人
		</td>
		<td>
			<div class="bxsheet_show"><?=$receiver?>&nbsp;</div>
		</td>
	</tr>	
	<tr>
		<td>
			服务评价
		</td>
		<td>
			<div class="bxsheet_show"><?=$assessment_content?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			维修人
		</td>
		<td>
			<div class="bxsheet_show"><?=$service_person?>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			主管
		</td>
		<td>
			<div class="bxsheet_show"><?=$supervisor?>&nbsp;</div>
		</td>
	</tr>
</table>
                <div id="submit1" align="center" style="padding: 0 0 20px 0">
                    
                        
                        
                        
                            <button class="btn btn-primary" onclick="document.location.href=url">
                                打印预览
                            </button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" onclick="document.location.href=host;">
                                返回
                            </button>
                        
                    
                </div>
 <script>
	var url=window.location.href;
	if(url.indexOf('iprint')>0)
		$("#submit1").hide();
	url=url.replace(/show/,'iprint');
	var i=url.lastIndexOf('/');
	var name=url.substring(i+1,url.length);
	var host=window.location.host;
	host='http://'+host+'/onlinebx_1.1/index.php/bxsheet';
</script>               
<?php
if(!strpos($_SERVER['PHP_SELF'],'iprint'))
	require_once 'v_foot.php';
?>
