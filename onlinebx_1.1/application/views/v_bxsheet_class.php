<style>
#operatebar
{
	padding:3px 0px 3px 0px;
}
</style>

<div class = "operatebar">
	<div class="tDiv">
		<div class="tDiv2">
			<div class="fbutton">
				<div>
					<span class="add" style="padding-left: 20px;" onclick="showModel('w','添加报修类别','<?=$root_url?>index.php/bxsheet_class/add','bxsheet_classform')">添加</span>
				</div>
			</div>
		<div style="clear: both;"></div>
		</div>
	</div>
</div>

<table class="datatable">
  <thead>
  <tr>
    <th>类别名称</th>
	<th>说明</th>
	<th>操作</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($bxsheet_classs as $bxsheet_class):?>
  <tr>
    <td><?=$bxsheet_class->name?></td>
	<td><?=$bxsheet_class->profile?></td>
	<td>
	<a href="javascript:void(0)" onclick="showModel('w','编辑角色','<?=$root_url?>index.php/bxsheet_class/edit/<?=$bxsheet_class->id?>','bxsheet_classform')">编辑</a> 
	<a href="<?=$root_url?>index.php/bxsheet_class/delete/<?=$bxsheet_class->id?>" onclick="return confirm('确定将此记录删除?')">删除</a> 
	</td> 
  </tr>
  <?php endforeach;?>
  </tbody>
</table> 