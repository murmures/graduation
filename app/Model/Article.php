<?php
class Article extends AppModel {
	public $belongsTo = array("Category");
	public $hasMany = array("ArticlesTag");
}
