<div class=""><?php echo $this->Html->image('banner.png', array('alt' => '', 'width'=>'940', 'height' => '140'));?></div>
<!-- navbar -->
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <div class="nav-collapse collapse navbar-responsive-collapse">
        <ul class="nav">
        	<?php $uri = $this->params["controller"]."-".$this->params["action"]; ?>
          <li class="<?php if ($uri == "articles-index"): ?>active<?php endif; ?>"><a href="<?php echo $this->Html->url('/')?>"><i class='icon-home'></i> 首页</a></li>
          <li class="<?php if ($uri == "articles-notification"): ?>active<?php endif; ?>"><a href="<?php echo $this->Html->url('/articles/notification')?>"><i class='icon-bullhorn'></i> 毕业通知</a></li>
          <li class="<?php if ($uri == "articles-task"): ?>active<?php endif; ?>"><a href="<?php echo $this->Html->url('/articles/task')?>"><i class='icon-briefcase'></i> 毕业生工作</a></li>
          <li class="dropdown <?php if ($uri == "articles-guide"): ?>active<?php endif; ?>">
            <a href="<?php echo $this->Html->url('/articles/guide')?>" class="dropdown-toggle" style="" data-toggle="dropdown"><i class='icon-pencil'></i> 毕业论文指导 <b class="caret"></b></a>
            <ul class="dropdown-menu" style="">
              <li><a href="<?php echo $this->Html->url('/articles/guide/paper')?>">选题指导 </a></li>
              <li><a href="<?php echo $this->Html->url('/articles/guide/writing')?>">写作指导</a></li>
              <!--
              	<li><a href="<?php echo $this->Html->url('/articles/guide/format')?>">格式规范</a></li>
              -->
            </ul>
          </li>
          <!--
          	<li class="<?php if ($uri == "articles-download"): ?>active<?php endif; ?>"><a href="<?php echo $this->Html->url('/articles/download')?>"><i class='icon-download-alt'></i> 文件下载</a></li>
          -->
          <li class="<?php if ($uri == "articles-lecture"): ?>active<?php endif; ?>"><a href="<?php echo $this->Html->url('/articles/lecture')?>"><i class='icon-headphones'></i> 毕业论文讲座</a></li>
          <li class="<?php if ($uri == "articles-degree"): ?>active<?php endif; ?>"><a href="<?php echo $this->Html->url('/articles/degree')?>"><i class='icon-user'></i> 学位管理</a></li>
       	</ul>
       	<ul class="nav pull-right">
       		<li>
<!--       	
						<form class="navbar-form pull-right">
       				<input name="search" class="input-medium" placeholder="标题关键字" value="" type="text" id="ArticleSearch"/>
       				<button class="btn" type="text" autocomplete="off" data-loading-text="<i class='icon-time'></i> 搜索中"><i class="icon-search"></i> 搜索</button>
       			</form>
-->
       			<?php 
       				echo $this->Form->create('Article', array("type" => "get", "action" => "search", "class" => array("navbar-form", "pull-right")));
							echo $this->Form->input('Article.keyword', array("div" => false, "type" => "text", "label" => false, "placeholder" => "标题关键字", "class" => "input-medium"));
       				// echo $this->Form->end("Submit");
       			?>
       			<button class="btn" type="text" autocomplete="off" data-loading-text="<i class='icon-time'></i> 搜索中"><i class="icon-search"></i> 搜索</button>
       			<?php echo $this->Form->end();?>
       		</li>
       	</ul> 	
      </div><!-- /.nav-collapse -->
    </div>
  </div><!-- /navbar-inner -->
</div>
