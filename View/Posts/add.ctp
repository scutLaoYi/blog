<div class="posts form">
<?php echo $this->Form->create('Post'); ?>
	<fieldset>
		<legend><?php echo __('写新的博客'); ?></legend>
	<?php
		echo $this->Form->input('title', array('label' => '标题'));
		echo $this->Form->input('body', array('label' => '正文'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('提交')); ?>
</div>
<div class="actions">
	<h3><?php echo __('操作'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('返回博客列表'), array('action' => 'index')); ?></li>
	</ul>
</div>
