<table class="table table-striped table-hover table-condensed">
	<tbody>
		<?php foreach ($files as $file):?>
			<tr class="font12">
				<td title="<?php echo $file['File']['description'];?>"><a href="<?php echo $this->Html->url("/".$file['File']['path']);?>"><?php echo $this->Text->truncate($file['File']['name'], 33); ?></a></span></td>
				<td class="text-right"><?php echo date("Y-m-d", strtotime($file['File']['created'])); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>