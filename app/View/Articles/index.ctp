<?php
	$this->extend('/Pages/home');
?>
<?php 
	if (!empty($this->params["pass"][0]) AND $this->params["pass"][0] == "all") {}
	else echo $this->element("widget/slide"); 
?>
	
<table class="table table-striped table-hover table-condensed">
	<tbody>
		<?php foreach ($articles as $article):?>
			<tr class="font12"><td><span><a href="<?php echo $this->Html->url("/view/{$article['Article']['id']}");?>">[<?php echo $article['Category']['name']; ?>] <?php  echo $article['Article']['title']; ?></a></span></td><td class="text-right"><?php echo date("Y-m-d", strtotime($article['Article']['modified'])); ?></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>
<a href="<?php echo $this->Html->url("/index/all");?>"><span class="pull-right label label-info">更多</span></a>