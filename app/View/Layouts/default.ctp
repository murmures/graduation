<!DOCTYPE html>
<html lang="zh-cn" xmlns:wb=“http://open.weibo.com/wb”>
	<head>
		<meta charset="utf-8">
		<title>
			中南大学网络教育学院毕业学位管理 | <?php echo $title_for_layout; ?>
		</title>
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css(array(
				"/glyphicons/css/glyphicons",
				"/bootstrap/css/bootstrap.min.css",
				"bootstrap-mod",
				"app.custom",
			));
			// if (file_exists(WWW_ROOT.DS."css".DS.$this->params["controller"].".css")) echo $this->Html->css($this->params["controller"]);
			// if (file_exists(WWW_ROOT.DS."css".DS.$this->params["controller"]."-".$this->params["action"].".css")) echo $this->Html->css($this->params["controller"]."-".$this->params["action"]);
			
			echo $this->Html->script(array(
				'jquery.min.js',
				'jquery.form.min',
				"/bootstrap/js/bootstrap.min.js",
				"app.common"
			));
			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<?php echo $this->Html->script("html5shiv"); ?>
		<![endif]-->
	</head>
	
	<body class="<?php echo $this->params->controller; ?>">
		<div class="main container">
			<?php echo $this->element("struct/header");?>
			<div class="row-fluid">
				<?php echo $this->fetch('content'); ?>
				<div id="right-sidebar" class="span3">
					<?php echo $this->element("struct/right-sidebar");?>
				</div>
			</div>
			<hr />
			<?php echo $this->element("struct/footer");?>
		</div>
		<?php if (isset($_GET["sql"])) echo $this->element('sql_dump'); ?>
	</body>
</html>