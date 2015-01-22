<style>
#operatebar
{
	padding:1px 0px 1px 0px;
}
</style>
<!--div class = "operatebar">
	<a class="btn" href="javascript:void(0)" onclick="showModel('w','添加用户','<?=$root_url?>index.php/user/add','userform')"> 添  加  </a>
</div-->
<script>
function add(btn,grid)
{
	showModel('w','添加用户','<?=$root_url?>index.php/user/add','userform');
}

$(function(){
	width = (getBrowser().name=="IE" && getBrowser().version < 7)?780:782;
	flexi_grid({buttons:[{name: '添加', bclass: 'add',onpress : add}],width:width});    
});
</script>

<table class='flexi_grid' id="user">
  <thead>
	  <tr>
		<th width="60">帐号</td>
		<th width="60">姓名</td>
		<th width="88">电话</td>
		<th width="100">手机</td>
		<th width="100">报修部门名称</td>    
		<th width="110">报修部门地址</td>
		<th width="20">禁用</td>
		<th width="60">角色</td>
		<th width="60">操作</td>
		<!--th width="80">操作</td-->
	  </tr>
  </thead>
  <tbody>
  <? foreach($users as $user):?>
  <div class="fgrid_opebtn_container" style="display:none">
	<a href="javascript:void(0)" onclick="showModel('w','编辑用户','<?=$root_url?>index.php/user/edit/<?=$user->userid?>','userform')">编辑</a> 
	<a href="<?=$root_url?>index.php/user/delete/<?=$user->userid?>" onclick="return confirm('删除用户,会将和其相关的数据全部删除,确定执行些操作吗?')">删除</a> 
  </div>
  <tr>
    <td><?=$user->username?></td>
	<td><?=$user->realname?></td>
	<td><?=$user->workphone?></td>
	<td><?=$user->mobilephone?></td>
	<td><?=$user->company?></td>
	<td><?=$user->work_addr_province.$user->work_addr_city.$user->work_addr_detail?></td>
	<td><?=$user->banned==0?"<font color='blue'>否</font>":"<font color='red'>是</font>"?></td> 
	<td><?=$user->rolename?></td>
	<td>
		<!--input type="button" class='fgrid_expand_button' value="展开"/-->
		<a href="javascript:void(0)" onclick="showModel('w','编辑用户','<?=$root_url?>index.php/user/edit/<?=$user->userid?>','userform')">编辑</a> 
		<a href="<?=$root_url?>index.php/user/delete/<?=$user->userid?>" onclick="return confirm('删除用户,会将和其相关的数据全部删除,确定执行些操作吗?')">删除</a> 
	</td>
  </tr>
  
  <?php endforeach;?>
  

  </tbody>
</table>

<?
	$this->load->view(
		'v_pager',
		array(
			'controller'=>'user',
			'action'=>'index',
			'current_page'=>$current_page,
			'pre_page'=>$pre_page,
			'next_page'=>$next_page,
			'page_count'=>$page_count
		)
	)
?>