<div class="commets form">
<?php echo $this->Form->create('Commet'); ?>
	<fieldset>
		<legend><?php echo __('Add Commet'); ?></legend>
	<?php
		//echo $this->Form->input('user_id', array('type'=>'text'));
		//echo $this->Form->input('post_id', array('type'=>'text'));
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Commets'), array('action' => 'index')); ?></li>
	</ul>
</div>
