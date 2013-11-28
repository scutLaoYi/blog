<div class="action_list">
	<h3><?php echo __('操作'); ?></h3>
	<ul>
		<li class="action"><div class="button"><?php echo $this->Html->link(__('返回博客目录'), array('action' => 'index')); ?></div></li>
		<li class="action"><div class="button"><?php echo $this->Form->postLink(__('删除该博文'), array('action' => 'delete', $this->Form->value('Post.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Post.id'))); ?></div></li>

	</ul>
</div>
<div class="posts form">
<?php echo $this->Form->create('Post'); ?>
	<fieldset>
		<legend><?php echo __('Edit Post'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('body');
	?>
	<?php echo $this->Form->end(__('Submit')); ?>
	</fieldset>
</div>

