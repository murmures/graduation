<?php
class ArticlesController extends AppController {
	public $uses = array("Article", "Slide", "File");
	public $components = array("Session", "Paginator");

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
					"Article.created" => "DESC"
				),
				"limit" => 4
		));
		$this->set(compact('faqs'));
	}

	function test() {
		mssql_connect("202.197.55.19:1433", "mis_lzl", "CSU_mis_lzl47894892");
		mssql_select_db("Cne_edu");
		// $sql = "SELECT * FROM dbo.FS_NS_BuzClass";
		// $sql = "SELECT GETDATE()";
		$sql = "SELECT * FROM FS_NS_BuzClass";
		// $sql = "SELECT * FROM Fs_news_xygg WHERE BuzID=008";
		$result = mssql_query($sql);
		debug(mssql_num_rows($result));
		debug($result);
		// $row = mssql_fetch_array($result);
		// debug($row);
		
		if (!mssql_num_rows($result)) {
			echo 'No records found';
		} else {
	    while ($row = mssql_fetch_array($result)) {
				debug($row);
	    }
		}
		
		mssql_free_result($result);die;
	}

	function test2() {
		try { 
			$hostname='202.197.55.19';//注意,这里和上面不同,要直接用IP地址或主机名 
			$port=1433;//端口 
			$dbname="Cne_edu";//库名 
			$username="mis_lzl";//用户 
			$pw="CSU_mis_lzl47894892";//密码 
			$dbh= new PDO("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$pw"); 
		} catch (PDOException $e) { 
			echo"Failed to get DB handle: ".$e->getMessage() ."\n"; 
			exit; 
		} 
		// echo'connent MSSQL succeed'; 
			// $stmt=$dbh->prepare("SELECT * FROM FS_NS_BuzClass"); 
			$stmt=$dbh->prepare("SELECT id,title,data FROM Fs_news_xygg WHERE BuzID=008 AND data >= '2012-01-01' ORDER BY data DESC"); 
			$stmt->execute(); 
			while ($row=$stmt->fetch()) { 
			debug($row); 
		} 
		unset($dbh); unset($stmt); die;
	}
	
	function import_news($type = "graduation") {
		try { 
			$hostname='202.197.55.19';//注意,这里和上面不同,要直接用IP地址或主机名 
			$port=1433;//端口 
			$dbname="Cne_edu";//库名 
			$username="mis_lzl";//用户 
			$pw="CSU_mis_lzl47894892";//密码 
			$dbh= new PDO("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$pw"); 
		} catch (PDOException $e) { 
			echo"Failed to get DB handle: ".$e->getMessage() ."\n"; 
			exit; 
		}
		switch ($type) {
			case "graduation":
				$type_id = "007";
				$category_id = 1;
				break;
			case "degree":
				$type_id = "008";
				$category_id = 8;
				break;
			default:
				break;
		}
		if (!empty($type_id)) {
			$stmt=$dbh->prepare("SELECT id,title,data FROM Fs_news_xygg WHERE BuzID={$type_id} AND data >= '2000-01-01' ORDER BY data DESC"); 
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				unset($article);
				$article["Article"]["external_id"] = $row["id"];
				$article["Article"]["category_id"] = $category_id;
				$article["Article"]["title"] = $row["title"];
				$article["Article"]["created"] = date("Y-m-d H:i:s", strtotime($row["data"]));
				debug($article);
				$exist_article = $this->Article->findByExternalId($row["id"]);
				if (empty($exist_article)) {
					$this->Article->create();
					$this->Article->save($article);
				}
			}
		}
		die;
	}

	function index($pass = null) {
		$faq_cat = $this->Article->Category->findByAlias("faq");
		
		if (!empty($pass) AND $pass == "all") {
			$this->paginate = array(
				"limit" => 10,
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id <>" => $faq_cat["Category"]["id"]
				),
				"order" => array(
					"Article.created" => "DESC"
				),
			);
			
			$articles = $this->paginate("Article");
		} else {
			$articles = $this->Article->find('all', 
				array(
					"contain" => array("Category"),
					"conditions" => array(
						"Article.category_id <>" => $faq_cat["Category"]["id"]
					),
					"order" => array(
						"Article.created" => "DESC"
					),
					"limit" => 10
			));
		}
		
		$this->set(compact('articles'));
	}
	
	function all() {
		$faq_cat = $this->Article->Category->findByAlias("faq");
		$this->paginate = array(
			"Article" => array(
				"limit" => 15,
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id <>" => $faq_cat["Category"]["id"]
				),
				"order" => array(
					"Article.created" => "DESC"
				),
			),
		);
		
		$articles = $this->paginate("Article");
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
			$this->redirect("/articles/edit/".$id);
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
			$this->paginate = array(
				"Article" => array(
					"limit" => 15,
					"contain" => array("Category"),
					"conditions" => array(
						"Article.title LIKE" => "%".$this->params->query["keyword"]."%"
					),
					"order" => array(
						"Article.created" => "DESC"
					),
				),
			);
			
			$articles = $this->paginate("Article");
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
			$this->paginate = array(
				"Article" => array(
					"limit" => 15,
					"contain" => array("Category"),
					"conditions" => array(
						"Article.id" => $article_ids
					),
					"order" => array(
						"Article.created" => "DESC"
					),
				),
			);
			
			$articles = $this->paginate("Article");
			$this->set(compact('articles'));
		}
	}
	
	function notification() {
		$cat = $this->Article->Category->findByAlias('notification');
		$this->paginate = array(
			"Article" => array(
				"limit" => 15,
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id" => $cat['Category']['id']
				),
				"order" => array(
					"Article.created" => "DESC"
				),
			),
		);
		
		$articles = $this->paginate("Article");
		$this->set(compact('articles'));
	}
	
	function task() {
		$cat = $this->Article->Category->findByAlias('task');
		$this->paginate = array(
			"Article" => array(
				"limit" => 15,
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id" => $cat['Category']['id']
				),
				"order" => array(
					"Article.created" => "DESC"
				),
			),
		);
		
		$articles = $this->paginate("Article");
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
						$this->paginate = array(
							"Article" => array(
								"limit" => 15,
								"contain" => array("Category"),
								"conditions" => array(
									"Article.category_id" => $cat_ids
								),
								"order" => array(
									"Article.created" => "DESC"
								),
							),
						);
						
						$articles = $this->paginate("Article");
						$this->set(compact('articles'));
					}
				}
				break;
			default:
				$cat = $this->Article->Category->findByAlias($params);
				if (!empty($cat)) {
					$this->paginate = array(
						"Article" => array(
							"limit" => 15,
							"contain" => array("Category"),
							"conditions" => array(
								"Article.category_id" => $cat['Category']['id']
							),
							"order" => array(
								"Article.created" => "DESC"
							),
						),
					);
					
					$articles = $this->paginate("Article");
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
		$cat = $this->Article->Category->findByAlias("degree");
		if (!empty($cat)) {
			$this->paginate = array(
				"Article" => array(
					"limit" => 15,
					"contain" => array("Category"),
					"conditions" => array(
						"Article.category_id" => $cat['Category']['id']
					),
					"order" => array(
						"Article.created" => "DESC"
					),
				),
			);
			
			$articles = $this->paginate("Article");
			$this->set(compact('articles'));
		}
	}
	
	function faq() {
		$cat = $this->Article->Category->findByAlias('faq');
		$this->paginate = array(
			"Article" => array(
				"limit" => 15,
				"contain" => array("Category"),
				"conditions" => array(
					"Article.category_id" => $cat['Category']['id']
				),
				"order" => array(
					"Article.created" => "DESC"
				),
			),
		);
		
		$articles = $this->paginate("Article");
		$this->set(compact('articles'));
	}
	
	function files() {
		$this->paginate = array(
			"File" => array(
				"limit" => 15,
				"order" => array(
					"File.created" => "DESC"
				),
			),
		);
		
		$files = $this->paginate("File");
		$this->set(compact('files'));
	}
}
