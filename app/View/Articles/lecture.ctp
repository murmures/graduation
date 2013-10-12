<?php
	$this->extend('/Pages/home');
?>
<table class="table">
	<?php foreach ($lectures as $lecture):?>
	<tr>
		<td>
			<div class="lecture-info">
				<div class="row-fluid">
					<div class="span5 thumbnail margin-left5">
						<!--<img src="holder.js/210x100">-->
						<img src="img/<?php echo $lecture["img"];?>" alt=""/>
					</div>
					<div class="span6 pull-right">
						<table class="lecture table-condensed">
							<thead>
								<tr><th colspan="2"><strong><?php echo $lecture["name"];?></strong></th></tr>
							</thead>
							<tbody>
								<tr><td width="70px"><span>主讲人</span></td><td width="120px"><?php echo $lecture["teacher"];?>&nbsp;&nbsp;&nbsp;<span class="font12"><?php echo $lecture["title"];?></span></td></tr>
								<tr><td width="70px"><span>专业</span></td><td><?php echo $lecture["major"];?></td></tr>
								<tr><td colspan="2" class="center"><a href="<?php echo $lecture["link"];?>" target="_blank" role="button" class="btn">点击观看</a></td></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</td>
	</tr>
	<?php endforeach; ?>
</table>