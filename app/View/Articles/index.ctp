<?php
	$this->extend('/Pages/home');
?>
<?php echo $this->element("widget/slide"); ?>

<?php echo $this->element("struct/content");?>

<a href="<?php echo $this->Html->url("/articles/all");?>"><span class="pull-right label label-info">更多</span></a>