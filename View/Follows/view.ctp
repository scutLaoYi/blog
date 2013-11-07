<div class="follows view">
<h2><?php echo __('Follow'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($follow['Follow']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Follower Id'); ?></dt>
		<dd>
			<?php echo h($follow['Follow']['follower_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Following Id'); ?></dt>
		<dd>
			<?php echo h($follow['Follow']['following_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Following Name'); ?></dt>
		<dd>
			<?php echo h($follow['Follow']['following_name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Follow'), array('action' => 'edit', $follow['Follow']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Follow'), array('action' => 'delete', $follow['Follow']['id']), null, __('Are you sure you want to delete # %s?', $follow['Follow']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Follows'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Follow'), array('action' => 'add')); ?> </li>
	</ul>
</div>
