<div id="tagging">
	<?php foreach ($tags as $tag):?>
		<?php
			$checked = false;
			if(!empty($article['ArticlesTag'])) {
				foreach ($article['ArticlesTag'] as $article_tag) {
					if ($tag["Tag"]["id"] == $article_tag["tag_id"]) {
						$checked = true;break;
					}
				}
			}
		?>
		<?php echo $this->Form->input($tag["Tag"]["title"], array("name" => "Tag[{$tag["Tag"]["id"]}]", "type"=>"checkbox", "checked" => $checked));?>
	<?php endforeach;?>
</div>