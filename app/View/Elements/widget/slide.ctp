<div id="myCarousel" class="carousel slide">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <!-- Carousel items -->
  <div class="carousel-inner">
  	<div class="item thumbnail active">
  		<a href="#"><?php echo $this->Html->image('flash1.png', array('alt' => '', 'width'=>'530', 'height' => '210'));?></a>
      <div class="carousel-caption">
        <p class="font12">毕业散文征集</p>
      </div>
    </div>
    <div class="item thumbnail">
  		<a href="#"><?php echo $this->Html->image('flash2.png', array('alt' => '', 'width'=>'530', 'height' => '210'));?></a>
      <div class="carousel-caption">
        <p class="font12">优秀毕业生评选</p>
      </div>
    </div>
    <div class="item thumbnail">
  		<a href="#"><?php echo $this->Html->image('flash3.png', array('alt' => '', 'width'=>'530', 'height' => '210'));?></a>
      <div class="carousel-caption">
        <p class="font12">举行答辩工作的通知</p>
      </div>
    </div>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>