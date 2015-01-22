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
					<span class="add" style="padding-left: 20px;" onclick="showModel('w','添加评价类别','<?=$root_url?>index.php/assessment_class/add','assessment_classform')">添加</span>
				</div>
			</div>
		<div style="clear: both;"></div>
		</div>
	</div>
</div>

<table class="datatable" >
  <thead>
  <tr>
    <th>类别名称</th>
	<th>说明</th>
	<th>操作</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($assessment_classs as $assessment_class):?>
  <tr>
    <td><?=$assessment_class->name?></td>
	<td><?=$assessment_class->profile?></td>
	<td>
	<a href="javascript:void(0)" 
	onclick="showModel('w','编辑角色','<?=$root_url?>index.php/assessment_class/edit/<?=$assessment_class->id?>','assessment_classform')">编辑</a> <a href="<?=$root_url?>index.php/assessment_class/delete/<?=$assessment_class->id?>" onclick="return confirm('确定将此记录删除?')">删除</a> 
	</td> 
  </tr>
  <?php endforeach;?>
  </tbody> 
</table>
