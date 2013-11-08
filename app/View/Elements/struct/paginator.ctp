<?php if (!empty($articles)):?>
<div class="paginator">
<?php
	echo $this->Paginator->prev('上一页', null, null, array('class' => 'disabled'));
	echo " ".$this->Paginator->counter()." ";
	echo $this->Paginator->next('下一页', null, null, array('class' => 'disabled'));
?>
</div>
<?php endif;?>