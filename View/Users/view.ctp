<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
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
	</dl>
	<div class="actions">
		<?php echo $this->Html->link(__('博文列表'),array('controller'=>'Posts','action'=>'index')); ?> &nbsp;
		<?php echo $this->Html->link(__('修改密码'),array('controller'=>'Users','action'=>'edit',$user['User']['id'])); ?> &nbsp;
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
