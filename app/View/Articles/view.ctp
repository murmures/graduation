<?php
	$this->extend('/Pages/home');
?>
<div class="article-title"><h4><strong><?php echo $article["Article"]["title"]; ?></strong>&nbsp;<span class="font12"><a href="<?php echo $referer; ?>">返回</a></span></h4></div>
<br />
<div class="font13"><?php echo $article["Article"]["body"]; ?></div>