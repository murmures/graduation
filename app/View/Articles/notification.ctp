<?php
	$this->extend('/Pages/home');
?>
<table class="table table-striped table-hover table-condensed">
	<tbody>
		<?php foreach ($articles as $article):?>
			<tr class="font12"><td><span><a href="http://www.cnecsu.cn/news/<?php echo $article['Article']['external_id'];?>.htm" target="_blank">[<?php echo $article['Category']['name']; ?>] <?php  echo $article['Article']['title']; ?></a></span></td><td class="text-right"><?php echo date("Y-m-d", strtotime($article['Article']['created'])); ?></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>