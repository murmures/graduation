<div id="category">
	<?php echo $this->Form->input("category_id", array("label" => "文章类别", "type"=>"select", "selected" => $article["Article"]["category_id"], "options" => $categories));?>
</div>