
<style>
	.operatebar div.ttDiv /*toolbar*/ {
		background: #fafafa;
		position: relative;
		border: 1px solid #ccc;
		/* border-bottom: 0px; */ 
		overflow: hidden;
	}
</style>
<div style="width:780px;">
	<div style='color:red;padding-top:6px'><?=$error?></div>
	<div class = "operatebar">
		<div class="ttDiv">
			<div class="tDiv2">
				<div class="fbutton">
					<div>
						<span onclick="showModel('w','数据优化','<?=$root_url?>index.php/database/optimize','',360)">数据优化</span>   
					</div>
				</div>
				<div class="fbutton">
					<div>
						<span onclick="showModel('w','数据备份','<?=$root_url?>index.php/database/backup','database_backupform',360,false)">数据备份</span>
					</div>
				</div>
				<div class="fbutton">
					<div>
						<span onclick="showModel('w','数据恢复','<?=$root_url?>index.php/database/restore','database_restoreform',480,false)">数据恢复</span>
					</div>
				</div>
			<div style="clear: both;"></div>
			</div>
		</div>
	</div>

</div>
