<?php
class ArticlesController extends AppController {
	public $uses = array("Article", "Slide", "File");

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
				"order" => array(
					"Article.created DESC"
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
				),
				"order" => array(
					"Article.created DESC"
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
				),
				"order" => array(
					"Article.created DESC"
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
				),
				"order" => array(
					"Article.created DESC"
				)
		));
		$this->set(compact('articles'));
	}
	
	function guide($params = "all") {
		switch ($params) {
			case 'all':
				$parent_cat = $this->Article->Category->findByAlias("guide");
				if (!empty($parent_cat)) {
					$cats = $this->Article->Category->find("all", 
						array(
							"conditions" => array(
								"parent_id" => $parent_cat['Category']['id']
							)
					));
					if (!empty($cats)) {
						foreach ($cats as $cat) {
							$cat_ids[] = $cat['Category']['id'];
						}
						$articles = $this->Article->find('all', 
							array(
								"contain" => array("Category"),
								"conditions" => array(
									"category_id" => $cat_ids
								),
								"order" => array(
									"Article.created DESC"
								)
						));
						$this->set(compact('articles'));
					}
				}
				break;
			default:
				$cat = $this->Article->Category->findByAlias($params);
				if (!empty($cat)) {
					$articles = $this->Article->find('all', 
						array(
							"contain" => array("Category"),
							"conditions" => array(
								"category_id" => $cat['Category']['id']
							),
							"order" => array(
								"Article.created DESC"
							)
					));
					$this->set(compact('articles'));
				}
				break;
		}
	}
	
	function download() {
		$files = $this->File->find('all');
		$this->set(compact('files'));
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
				),
				"order" => array(
					"Article.created DESC"
				)
		));
		$this->set(compact('articles'));
	}
}
