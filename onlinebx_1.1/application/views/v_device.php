<style>
#operatebar
{
	padding:1px 0px 1px 0px;
}
</style>
<!--div class = "operatebar">
	<a class="btn" href="javascript:void(0)" onclick="showModel('w','添加用户','<?=$root_url?>index.php/device/add','deviceform')"> 添  加  </a>
</div-->
<script>
function add(btn,grid)
{
	showModel('w','添加设备','<?=$root_url?>index.php/device/add','deviceform');
}

$(function(){
	width = (getBrowser().name=="IE" && getBrowser().version < 7)?780:782;
	flexi_grid({buttons:[{name: '添加', bclass: 'add',onpress : add}],width:width});    
});
</script>

<table class='flexi_grid' id="device">
  <thead>
	  <tr>
		<th width="80">编号</td>
		<th width="60">类型</td>
		<th width="60">品牌</td>
		<th width="90">型号</td>
		<th width="40">数量</td> 
		<th width="88">购买日期</td> 
		<th width="180">所属客户</td>
		<th width="60">操作</td>
		<!--th width="80">操作</td-->
	  </tr>
  </thead>
  <tbody>
  <? foreach($devices as $device):?>
  <tr>
    <td><?=$device->number?></td>
	<td><?=$device->type?></td>
	<td><?=$device->brand?></td>
	<td><?=$device->count?></td>
	<td><?=$device->buy_time?></td>
	<td><?=$device->model?></td>
	<td><?=$device->model?></td>
	<td><?=$device->user?></td>
	<td>
		<!--input type="button" class='fgrid_expand_button' value="展开"/-->
		<a href="javascript:void(0)" onclick="showModel('w','编辑设备','<?=$root_url?>index.php/device/edit/<?=$device->id?>','deviceform')">编辑</a> 
		<a href="<?=$root_url?>index.php/device/delete/<?=$device->id?>" onclick="return confirm('确定执行些操作吗?')">删除</a> 
	</td>
  </tr>
  
  <?php endforeach;?>
  </tbody>
</table>

<?
	$this->load->view(
		'v_pager',
		array(
			'controller'=>'device',
			'action'=>'index',
			'current_page'=>$current_page,
			'pre_page'=>$pre_page,
			'next_page'=>$next_page,
			'page_count'=>$page_count
		)
	)
?>