<div class="jr_pager">
	<div class="jr_pager_indent">
		<table><tr>
			<td>
				<a href="<?=$root_url?>index.php/<?=$controller?>/<?=$action?>/1">
				<img src="<?=$root_url?>application/views/images/first.gif"/>
				</a>
			</td>
			<td>
				<a href="<?=$root_url?>index.php/<?=$controller?>/<?=$action?>/<?=$pre_page?>">
				<img src="<?=$root_url?>application/views/images/prev.gif"/>
				</a>
			</td>
			<td>
				<? for($i=(($page_count-2)<1?1:($page_count-2));$i<=(($current_page+2)>$page_count?$page_count:($current_page+2));$i++){?>
				<a href="<?=$root_url?>index.php/<?=$controller?>/<?=$action?>/<?=$i?>">
					<font <?=($i==$current_page)?"style='color:red'":""?>>[<?=$i?>]</font> 
				</a> 
				<? }?>
			</td>
			<td>
				<a href="<?=$root_url?>index.php/<?=$controller?>/<?=$action?>/<?=$next_page?>" class="next">
				<img src="<?=$root_url?>application/views/images/next.gif"/>
				</a>
			</td>
			<td>
				<a href="<?=$root_url?>index.php/<?=$controller?>/<?=$action?>/<?=$page_count?>">  
				<img src="<?=$root_url?>application/views/images/last.gif"/> 
				</a>
			</td>
		</tr></table>
		
	</div>
</div>