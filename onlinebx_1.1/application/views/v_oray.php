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
					<span class="add" style="padding-left: 20px;" onclick="showModel('w','添加向日葵帐户','<?=$root_url?>index.php/oray/add','orayform',660)">添加向日葵帐户</span>
				</div>
			</div>
		<div style="clear: both;"></div>
		</div>
	</div>
</div>

<table class="datatable">
  <thead>
  <tr>
    <th>帐户</th>
	<th>密码</th>
	<th>简介</th>
	<th width="116">操作</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($orays as $oray):?>
  <tr> 
    <td><?=$oray->username?></td>
	<td>********</td>
	<td><?=$oray->profile?></td>
	<td>
		<a href="<?=$root_url?>index.php/oray/autologin/<?=$oray->id?>" target="_blank">自动登录</a> 
		<a href="javascript:void(0)" onclick="showModel('w','编辑向日葵帐号','<?=$root_url?>index.php/oray/edit/<?=$oray->id?>','orayform',660)">编辑</a>
		<a href="<?=$root_url?>index.php/oray/delete/<?=$oray->id?>" onclick="return confirm('确定将此记录删除?')">删除</a>
	</td> 
  </tr>
  <?php endforeach;?>
  <tbody>
</table>
