<?php
class ArticlesTag extends AppModel {
	public $belongsTo = array(
		"Article", 
		"Tag" => array(
			"counterCache" => array(
				"count" => true
			)
		)
	);
}
