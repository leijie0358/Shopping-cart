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
					<span class="add" style="padding-left: 20px;" onclick="showModel('w','添加用户','<?=$root_url?>index.php/role/add','roleform')">添加</span>
				</div>
			</div>
		<div style="clear: both;"></div>
		</div>
	</div>
</div>

<table class="datatable">
  <thead>
  <tr>
    <th>角色名称</th>
	<th>说明</th>
	<th>类型</th>
	<th>操作</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($roles as $role):?>
  <tr>
    <td><?=$role->name?></td>
	<td><?=$role->profile?></td>
	<td><?=$role->type==0?"默认":($role->type==1?"客户":($role->type==2?"工程师":"超级管理员"))?></td>
	<td>
		<a href="javascript:void(0)" onclick="showModel('w','编辑角色','<?=$root_url?>index.php/role/edit/<?=$role->id?>','roleform')">编辑</a>

		<?if($role->type != 3){ ?>
		<a href="javascript:void(0)" onclick="showModel('w','授权','<?=$root_url?>index.php/role/permission/<?=$role->id?>','permissionform')">授权</a>
		<?}?>
	
		<a href="<?=$root_url?>index.php/role/delete/<?=$role->id?>" onclick="return confirm('确定将此记录删除?')">删除</a> 
		
	</td> 
  </tr>
  <?php endforeach;?>
  <tbody>
</table>
