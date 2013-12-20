<?php if (empty($articles)):?>
该分类下没有文章
<?php else:?>
<table class="table table-striped table-hover table-condensed">
	<tbody>
		<?php foreach ($articles as $article):?>
			<tr class="font12"><td title="<?php echo $article['Article']['title'];?>">
				<?php if (!empty($article['Article']['external_id'])):?>
					<span><a href="http://www.cnecsu.cn/news/<?php echo $article['Article']['external_id'];?>.htm" target="_blank">
				<?php else:?>
					<span><a href="<?php echo $this->Html->url("/articles/view/{$article['Article']['id']}");?>">
				<?php endif;?>
					[<?php echo $article['Category']['name']; ?>]<?php echo $this->Text->truncate($article['Article']['title'], 33); ?></a></span></td><td class="text-right"><?php echo date("Y-m-d", strtotime($article['Article']['created'])); ?></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif;?>