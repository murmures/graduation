<div id="question">
	<span class="font13"><i class='icon-question-sign'></i> 常见问题</span>
	<ul class="">
		<?php foreach($faqs as $faq):?>
			<li class="font12"><span><a href="<?php echo $this->Html->url("/articles/view/{$faq['Article']['id']}");?>"><?php echo $faq['Article']['title'];?></a></span></li>
		<?php endforeach; ?>
	</ul>
	<div><a href="<?php echo $this->Html->url("/faq");?>"><span class="pull-right label label-info">更多</span></a></div>
</div>