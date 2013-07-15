<?php if (!empty($slides)): ?>
<div id="myCarousel" class="carousel slide">
  <ol class="carousel-indicators">
  	<?php foreach($slides as $key=>$slide):?>
  		<li data-target="#myCarousel" data-slide-to="<?php echo $key;?>" class="<?php echo $key==0?"active":''?>"></li>
  	<?php endforeach; ?>
  </ol>
  <!-- Carousel items -->
  <div class="carousel-inner">
  	<?php foreach($slides as $key=>$slide):?>
  		<div class="item thumbnail <?php echo $key==0?"active":''?>">
	  		<a href="<?php echo $this->Html->url($slide["Slide"]["href"]);?>"><?php echo $this->Html->image($slide["Slide"]["slide"], array('alt' => '', 'width'=>'530', 'height' => '210'));?></a>
	      <div class="carousel-caption">
	        <p class="font12"><?php echo $slide["Slide"]["title"]; ?></p>
	      </div>
	    </div>
  	<?php endforeach; ?>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>
<?php endif; ?>