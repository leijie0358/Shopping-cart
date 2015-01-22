
<style>
input[type="submit"] 
{
	height:30px;
}

#searchsplitline
{
	margin-top: 10px;
}

.searchform td
{
	padding:3px 3px 3px 3px,
	font-size:10px
}
</style>   


<script src="<?=$root_url?>application/views/scripts/jqueryplugins/jquerytimers.js" type="text/javascript"></script> 

<script>
	function clear_search()
	{
		this.location.href = "<?=$root_url?>index.php/bxsheet/search/clearsearch"; 
	}
	$(function() {
		$( "#bx_time_begin" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		$( "#bx_time_end" ).datepicker({
			changeMonth: true,
			changeYear: true, 
			dateFormat: "yy-mm-dd"
		});
		$( "#bx_date" ).datepicker({
			changeMonth: true,
			changeYear: true, 
			dateFormat: "yy-mm-dd"
		});
	});

	$(document).ready(function(){
		
		$("#datatable").load("<?=$root_url?>index.php/bxsheet/datatable/<?=$page?>");

		$('body').everyTime('5s','a',function(){
			$("#datatable").load("<?=$root_url?>index.php/bxsheet/datatable/<?=$page?>");
		});

		$("#autorefresh").click(function(){
			if($(this).html() == "停止自动刷新")
			{
				$('body').stopTime('a');
				$(this).html("启动自动刷新");
			}
			else
			{
				$(this).html("停止自动刷新");
				$('body').everyTime('5s','a',function(){
					$("#datatable").load("<?=$root_url?>index.php/bxsheet/datatable/<?=$page?>"); 
				});
			}
		});
		
		$("#search").click(function() {
			
				var width = 480 ;
				var height = 390 ; 
				// alert('abc');
				$('#dialog-modal').dialog({
					position: [$('.flexi_grid').offset().left,$('.flexi_grid').offset().top - 28],  
					width : width,
					height :  height
					/*
					buttons : [
					{
						text: "查询",
						click: function() { $(this).dialog("close"); }
					}
					]
					*/
				});
				//alert(pos);
		});

		<?
			if($this->session->userdata['user']->role_type==1)
			{
		?>
			$('.custom').css('display','none');
		<?
			}
		?>
	});
</script>

<div id="dialog-modal" title="请输入条件" style="display:none;font-size:13px">

	<form action="<?=$searchaction?>" method="post" id="userform">
		<table class="searchform">
			<tr>
				<td>
					报修编号
				</td>
				<td>
					<input type="text" name="number" value=""></input>
				</td>
			</tr>
			<tr class='custom'>
				<td>
					申报人
				</td>
				<td>
					<select name="custom_id" id="custom_id"> 
						<option cinfo="" value="0">请选择</option>
						<?php foreach($customs as $custom):?>
						<option cinfo="<?=$custom->company."".$custom->realname."".$custom->workphone."".$custom->mobilephone?>" value="<?=$custom->id?>">
							<?=$custom->company."-".$custom->realname?>
						</option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					报修部门
				</td>
				<td>
					<input type="text" name="custom_company" value=""></input>
				</td>
			</tr>
			<tr>
				<td>
					申报人姓名
				</td>
				<td>
					<input type="text" name="custom_name" value=""></input>
				</td>
			</tr>
			<tr>
				<td>
					报修名称
				</td>
				<td>
					<select name="bxsheet_class_id">  
						<option cinfo="" value="0">请选择</option>
						<?php foreach($bxsheet_classs as $bxsheet_class):?>
						<option value="<?=$bxsheet_class->id?>">
							+<?=$bxsheet_class->name?> 
						</option> 
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr class='custom'>
				<td>
					工作电话
				</td>
				<td>
					<input type="text" name="custom_workphone" value=""></input>
				</td>
			</tr>
			<tr class='custom'>
				<td>
					手机
				</td>
				<td>
					<input type="text" name="custom_mobilephone" value=""></input>
				</td>
			</tr>
			<tr>
				<td>
					报修地址
				</td>
				<td>
					<input type="text" name="custom_addr" value=""></input>
				</td>
			</tr>
			<tr>
				<td>
					报修时间
				</td>
				<td>
					<input type="text" name="bx_time_begin" id="bx_time_begin" value=""></input> 
					到 
					<input type="text" name="bx_time_end"  id="bx_time_end" value=""></input>
				</td>
			</tr>
			<tr>
				<td>
					故障现象
				</td>
				<td>
					<input type="text" name="fault_title" value=""></input>
				</td>
			</tr>
		</table>
		<hr size="1" width="100%" id="searchsplitline" /> 
		<input type="submit" value="   查   询   "></input>
	</form>

</div>

<div class = "operatebar">

	<div class="tDiv">
		<div class="tDiv2">
			<div class="fbutton">
				<div>
					<span class="add" style="padding-left: 20px;" onclick="document.location.href= '<?=$root_url?>index.php/bxsheet/add';">添加</span>
				</div>
			</div>
			<div class="fbutton">
				<div>
					<span id="search">搜索</span>
				</div>
			</div>
			<div class="fbutton">
				<div>
					<span id="autorefresh">停止自动刷新</span>
				</div>
			</div>
			<div class="fbutton">
				<div>
					<span onclick="clear_search()">清空查询结果</span>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>

<div id="datatable"></div>

