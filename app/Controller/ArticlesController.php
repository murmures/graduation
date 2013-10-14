<?php
class ArticlesController extends AppController {
	public $uses = array("Article", "Slide", "File");

	function beforeFilter() {
		$slides = $this->Slide->find("all");
		$this->set(compact('slides'));
		
		$referer = $this->referer();
		$this->set(compact('referer'));

		$tags = $this->Article->ArticlesTag->Tag->find("all");
		$this->set(compact('tags'));

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

	function index($pass = null) {
		$faq_cat = $this->Article->Category->findByAlias("faq");
		
		if (!empty($pass) AND $pass == "all") {
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
		} else {
			$articles = $this->Article->find('all', 
				array(
					"contain" => array("Category"),
					"conditions" => array(
						"Article.category_id <>" => $faq_cat["Category"]["id"]
					),
					"order" => array(
						"Article.created DESC"
					),
					"limit" => 10
			));
		}
		$this->set(compact('articles'));
	}
	
	function edit($id) {
		$categories = $this->Article->Category->find("list");
		$this->set(compact('categories'));

		$tags = $this->Article->ArticlesTag->Tag->find("all");
		$this->set(compact('tags'));
		$article = $this->Article->find("first", 
			array(
				"contain" => array(
					"ArticlesTag" => array(
						"Tag"
					)
				),
				"conditions" => array(
					"Article.id" => $id
				)
		));
		$this->set(compact('article'));

		if (!empty($this->data)) {
			debug($this->data);
			$to_save_article["Article"]["category_id"] = $this->data["Article"]["category_id"];
			
			$this->Article->id = $id;
			$this->Article->save($to_save_article);
			
			foreach ($this->data["Tag"] as $tag_id => $checked) {
				$existed = false;
				foreach ($article["ArticlesTag"] as $article_tag) {
					if ($tag_id == $article_tag["tag_id"]) {
						$existed = true;break;
					}
				}
				if ($checked) {
					if (!$existed) {
						$this->Article->ArticlesTag->create();
						$to_save_articles_tag["ArticlesTag"]["article_id"] = $article["Article"]["id"];
						$to_save_articles_tag["ArticlesTag"]["tag_id"] = $tag_id;
						$this->Article->ArticlesTag->save($to_save_articles_tag);
					}
				} else {
					if ($existed) {
						$to_delete_articles_tag = $this->Article->ArticlesTag->find("first", 
							array(
								"conditions" => array(
									"ArticlesTag.article_id" => $article["Article"]["id"],
									"ArticlesTag.tag_id" => $tag_id
								)
						));
						$this->Article->ArticlesTag->delete($to_delete_articles_tag["ArticlesTag"]["id"]);
					}
				}
			}
			$this->Session->setFlash("文章已修改!");
			$this->redirect("/edit/".$id);
		}
		
	}
	
	function view($id) {
		$article = $this->Article->find("first", 
			array(
				"contain" => array(
					"ArticlesTag" => array(
						"Tag"
					)
				),
				"conditions" => array(
					"Article.id" => $id
				)
		));
		$this->set(compact('article'));
	}
	
	function search() {
		if (!empty($this->params->query["keyword"])) {
			$articles = $this->Article->find('all', 
				array(
					"contain" => array("Category"),
					"conditions" => array(
						"Article.title LIKE" => "%".$this->params->query["keyword"]."%"
					),
					"order" => array(
						"Article.created DESC"
					)
			));
			$this->set(compact('articles'));
		}
	}
	
	function tag($tag_id) {
		$articles_tags = $this->Article->ArticlesTag->find("all", 
			array(
				"conditions" => array(
					"ArticlesTag.tag_id" => $tag_id,
				)
		));
		if (!empty($articles_tags)) {
			foreach ($articles_tags as $articles_tag) {
				$article_ids[] = $articles_tag["ArticlesTag"]["article_id"];
			}
			$articles = $this->Article->find('all', 
				array(
					"contain" => array("Category"),
					"conditions" => array(
						"Article.id" => $article_ids
					),
					"order" => array(
						"Article.created DESC"
					)
			));
			$this->set(compact('articles'));
		}
	}
	
	function notification() {
		$cat = $this->Article->Category->findByAlias('notification');
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id" => $cat['Category']['id']
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
					"Article.category_id" => $cat['Category']['id']
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
								"Category.parent_id" => $parent_cat['Category']['id']
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
									"Article.category_id" => $cat_ids
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
								"Article.category_id" => $cat['Category']['id']
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
		$lectures = array(
			array(
				"name" => "法学专业毕业论文讲座",
				"teacher" => "邵华",
				"major" => "法学",
				"title" => "副教授",
				"course" => "证据法学",
				"img" => "lecture-thumbnail-1.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=1"
			),
			array(
				"name" => "工商管理专业毕业论文讲座",
				"teacher" => "陈明淑",
				"major" => "工商管理",
				"title" => "副教授",
				"course" => "人力资源管理（专科）",
				"img" => "lecture-thumbnail-2.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=2"
			),
			array(
				"name" => "护理学专业毕业论文讲座",
				"teacher" => "阳爱云",
				"major" => "护理学",
				"title" => "副教授",
				"course" => "护理学基础",
				"img" => "lecture-thumbnail-3.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=3"
			),
			array(
				"name" => "计算机专业毕业论文讲座",
				"teacher" => "严晖",
				"major" => "计算机科学与技术",
				"title" => "副教授",
				"course" => "C++程序设计",
				"img" => "lecture-thumbnail-4.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=4"
			),
			array(
				"name" => "行政管理专业毕业论文讲座",
				"teacher" => "许源源",
				"major" => "行政管理",
				"title" => "副教授",
				"course" => "行政组织学",
				"img" => "lecture-thumbnail-5.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=5"
			),
			array(
				"name" => "交通运输毕业论文讲座",
				"teacher" => "叶峻青",
				"major" => "交通运输",
				"title" => "副教授",
				"course" => "铁路运输设备",
				"img" => "lecture-thumbnail-6.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=6"
			),
			array(
				"name" => "会计学毕业论文讲座",
				"teacher" => "易玄",
				"major" => "会计学",
				"title" => "副教授",
				"course" => "中级财务会计",
				"img" => "lecture-thumbnail-7.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=7"
			),
			array(
				"name" => "汉语言文学毕业论文讲座",
				"teacher" => "刘青松",
				"major" => "汉语言文学",
				"title" => "教授",
				"course" => "古代汉语",
				"img" => "lecture-thumbnail-8.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=8"
			),
			array(
				"name" => "机械自动化毕业论文讲座",
				"teacher" => "廖平",
				"major" => "机械设计与自动化",
				"title" => "教授",
				"course" => "",
				"img" => "lecture-thumbnail-9.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=9"
			),
			array(
				"name" => "土木工程毕业论文讲座",
				"teacher" => "娄平",
				"major" => "土木工程",
				"title" => "教授",
				"course" => "",
				"img" => "lecture-thumbnail-10.jpg",
				"link" => "http://www.cnecsu.cn/open/byvideo.html?id=10"
			),
		);
		$this->set(compact('lectures'));
	}
	
	function degree() {
		
	}
	
	function faq() {
		$cat = $this->Article->Category->findByAlias('faq');
		$articles = $this->Article->find('all', 
			array(
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id" => $cat['Category']['id']
				),
				"order" => array(
					"Article.created DESC"
				)
		));
		$this->set(compact('articles'));
	}
}
