<?php
class ArticlesController extends AppController {
	public $uses = array("Article", "Slide");

	function beforeFilter() {
		$slides = $this->Slide->find("all");
		$this->set(compact('slides'));
		
		$referer = $this->referer();
		$this->set(compact('referer'));

		$cat = $this->Article->Category->findByAlias("faq");
		$faqs = $this->Article->find("all", 
			array(
				"conditions" => array(
					"Article.category_id" => $cat["Category"]["id"]
				),
				"limit" => 4
		));
		$this->set(compact('faqs'));
	}

	function index() {
		$faq_cat = $this->Article->Category->findByAlias("faq");
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id <>" => $faq_cat["Category"]["id"]
				)
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
		$cat = $this->Article->Category->findByAlias('notification');
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category"),
				"conditions" => array(
					"category_id" => $cat['Category']['id']
				)
		));
		$this->set(compact('articles'));
	}
	
	function task() {
		$cat = $this->Article->Category->findByAlias('task');
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category"),
				"conditions" => array(
					"category_id" => $cat['Category']['id']
				)
		));
		$this->set(compact('articles'));
	}
	
	function guide() {
		
	}
	
	function download() {
		
	}
	
	function lecture() {
		
	}
	
	function degree() {
		
	}
	
	function faq() {
		$cat = $this->Article->Category->findByAlias('faq');
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category"),
				"conditions" => array(
					"category_id" => $cat['Category']['id']
				)
		));
		$this->set(compact('articles'));
	}
}
