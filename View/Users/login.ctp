<div class = "form">
<?php echo $this->Form->create('User'); ?>
<fieldset>
	<legend>Login</legend>
	<?php echo $this->Form->input('username',array('label'=>'username'));
		echo $this->Form->input('password',array('label'=>'password'));?>
	<?php echo $this->Form->end(__('Login')); ?>
</fieldset>

</div>
