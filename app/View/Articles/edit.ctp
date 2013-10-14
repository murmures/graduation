<?php
	$this->extend('/Pages/edit');
?>
<div class="article-title"><h4><strong><?php echo $article["Article"]["title"]; ?></strong>&nbsp;<span class="font12"><a href="<?php echo $referer; ?>">返回</a></span></h4></div>
<div class="article-tag font12">标签:
<?php
	if (!empty($article["ArticlesTag"])) {
		foreach ($article["ArticlesTag"] as $article_tag) {
			echo "&nbsp;&nbsp;".$this->Html->link($article_tag["Tag"]["title"], "/tag/{$article_tag["Tag"]["id"]}");
		}
	}
?>
</div>
<br />
<div class="font13"><?php echo $article["Article"]["body"]; ?></div>