<div class="commets view">
<h2><?php echo __('Commet'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($commet['Commet']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($commet['Commet']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Id'); ?></dt>
		<dd>
			<?php echo h($commet['Commet']['post_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($commet['Commet']['content']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Commet'), array('action' => 'edit', $commet['Commet']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Commet'), array('action' => 'delete', $commet['Commet']['id']), null, __('Are you sure you want to delete # %s?', $commet['Commet']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Commets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Commet'), array('action' => 'add')); ?> </li>
	</ul>
</div>
