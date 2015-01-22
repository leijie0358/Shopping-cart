<style>
#local
{
	padding-top:6px;
	font-size:12px;
}

</style>

<form enctype="multipart/form-data" action="<?=$action?>" id="database_restoreform" method="post">
<table class='datatable' id="dbrestore">
	<tr>
		<td >备份时间</td>
		<td>选择</td> 
	<tr> 
	<? foreach($files as $filename):?>
	<tr>
		<td align="center"><?=date('Y-m-d H:i',strtotime(substr($filename,0,strlen($filename)-4)))?></td>
		<td align="center">
			<input type="radio" name="filename" value="<?=$filename?>" />
		</td> 
	<tr> 
	<? endforeach;?>
</table>
<div id="local">
从本地文件恢复 <input name="localfilename" type="file" value="浏览" />
</div>
</form>
