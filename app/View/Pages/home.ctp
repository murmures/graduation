<?php
	$this->start('sidebar');
	echo $this->element("sidebar/tag");
	echo $this->element("sidebar/faq");
	$this->end();
	echo $this->fetch('content');
?>