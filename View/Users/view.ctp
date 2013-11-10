<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo h($user['User']['role']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
	<div class="actions">
		
			<?php echo $this->Html->link(__('关注博主'),array('controller'=>'Follows','action' => 'add',$user['User']['id'],$user['User']['username'])); ?> 
		
	</div>
	
	<table cellpadding ="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('following_name'); ?></th>
		<th class="actions"><<?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($follows as $follow): ?>
	<tr>
		<td><?php echo h($follow['Follow']['following_name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('取消关注'),array('controller'=>'Follows','action'=>'delete',$follow['Follow']['id']),null,__('Are you sure?')); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>

</div>
<div class="action">
	<h3><?php echo __('头像'); ?></h3>
		<?php 
			echo $this->Html->image('../head_image/'.$user['User']['image'], array('width' => '300', 'height'=>'300'));
		?>
		<?php
			echo $this->Form->create('Head', array('type'=>'file'));
			echo $this->Form->input('head_image', array('type'=>'file'));
			echo $this->Form->end('提交新头像');
		?>
</div>
