<?php
class ArticlesController extends AppController {
	public $uses = array("Article");

	function beforeFilter() {
		$referer = $this->referer();
		$this->set(compact('referer'));
	}

	function index() {
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category")
		));
		$this->set(compact('articles'));
	}
	
	function view($id) {
		$article = $this->Article->findById($id);
		$this->set(compact('article'));
	}
	
	function search() {
		
	}
	
	function tag() {
		
	}
	
	function notification() {
		$category = $this->Article->Category->find('first', 
			array(
				"conditions" => array(
					"alias" => 'notification'
				),
				"fields" => array(
					"id"
				)
		));
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category"),
				"conditions" => array(
					"category_id" => $category['Category']['id']
				)
		));
		$this->set(compact('articles'));
	}
	
	function task() {
		
	}
	
	function guide() {
		
	}
	
	function download() {
		
	}
	
	function lecture() {
		
	}
	
	function faq() {
		
	}
}
