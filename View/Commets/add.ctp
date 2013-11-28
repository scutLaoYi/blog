<div class="commets form">
<?php echo $this->Form->create('Commet'); ?>
	<fieldset class="commet">
		<legend><?php echo __('添加评论'); ?></legend>
	<?php
		//echo $this->Form->input('user_id', array('type'=>'text'));
		//echo $this->Form->input('post_id', array('type'=>'text'));
		echo $this->Form->input('content',array('label'=>'评论内容','rows'=>'5'));
	?>
		<?php echo $this->Form->end(__('提交')); ?>
	</fieldset>

</div>
