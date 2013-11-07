<div class="commets form">
<?php echo $this->Form->create('Commet'); ?>
	<fieldset>
		<legend><?php echo __('Edit Commet'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('post_id');
		echo $this->Form->input('user_name');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Commet.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Commet.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Commets'), array('action' => 'index')); ?></li>
	</ul>
</div>
