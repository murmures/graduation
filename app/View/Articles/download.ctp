<?php
	$this->extend('/Pages/home');
?>
	
<table class="table table-striped table-hover table-condensed">
	<tbody>
		<?php foreach ($files as $file) :?>
			<tr><td class="font12"><span><a href="<?php echo $this->Html->url("/".$file["File"]["path"]); ?>"><?php echo $file["File"]["name"];?></a></span></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>
<a href="#"><span class="pull-right label label-info">更多</span></a>