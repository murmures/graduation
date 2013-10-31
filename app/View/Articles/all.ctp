<?php
	$this->extend('/Pages/home');
?>
<table class="table table-striped table-hover table-condensed">
	<tbody>
		<?php foreach ($articles as $article):?>
			<tr class="font12"><td><span><a href="<?php echo $this->Html->url("/view/{$article['Article']['id']}");?>">[<?php echo $article['Category']['name']; ?>]<?php  echo $article['Article']['title']; ?></a></span></td><td class="text-right"><?php echo date("Y-m-d", strtotime($article['Article']['modified'])); ?></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div>
<?php
	echo $this->Paginator->prev('上一页', null, null, array('class' => 'disabled'));
	echo $this->Paginator->counter();
	echo $this->Paginator->next('下一页', null, null, array('class' => 'disabled'));
?>
</div>