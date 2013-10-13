<div id="tags">
	<span class="font13"><i class='icon-tag'></i> 所有标签</span>
	<ul>
		<?php foreach ($tags as $tag): ?>
			<?php 
				if ($tag["Tag"]["count"] <= 5) {
					$class = "tag1";
				} elseif ($tag["Tag"]["count"] > 5 AND $tag["Tag"]["count"] <= 10) {
					$class = "tag2";
				} elseif ($tag["Tag"]["count"] > 10 AND $tag["Tag"]["count"] <= 15) {
					$class = "tag3";
				} elseif ($tag["Tag"]["count"] > 15 AND $tag["Tag"]["count"] <= 20) {
					$class = "tag4";
				} elseif ($tag["Tag"]["count"] > 20) {
					$class = "tag5";
				} 
			?>
			<li class="<?php echo $class;?>"><a href="<?php echo $this->Html->url("/tag/{$tag["Tag"]["id"]}");?>"><?php echo $tag["Tag"]["title"];?></a></li> 
		<?php endforeach; ?>
	</ul>
</div>