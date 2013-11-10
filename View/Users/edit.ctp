<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('修改密码'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('old password');
		echo $this->Form->input('new password');
		echo $this->Form->input('confirm new password');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
