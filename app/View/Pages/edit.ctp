<?php
	$this->start('sidebar');
	echo $this->Form->create("Article");
	echo $this->element("sidebar/category");
	echo $this->element("sidebar/tagging");
	echo $this->Form->submit("Submit");
	echo $this->Form->end();
	$this->end();
	echo $this->fetch('content');
?>