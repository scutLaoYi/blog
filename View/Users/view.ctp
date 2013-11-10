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
	<div class='actions'>
	<?php
	if($is_follow=='-1')
	{
	echo $this->Html->link('关注',array('controller'=>'Follows','action'=>'add',$user['User']['id'],$user['User']['username']));
	}
	else
	{
	echo $this->Html->link('取消关注',array('controller'=>'Follows','action'=>'delete',$is_follow));
	}
	?>
	</div>
	</br></br></br>
	<h3>关注列表</h3>
	<table cellpadding="0" cellspacing="0">
	<?php if($flag)
	{
	 foreach($follow as $name):?>
	<tr>	
	<td><?php echo $this->Html->link(__($name['Follow']['following_name']),array('controller'=>'Posts','action'=>'user_posts',$name['Follow']['following_id']));?>
	</td>
	<td><?php echo $this->Html->link('取消关注',array('controller'=>'Follows','action'=>'delete',$name['Follow']['id']));?> </td>
	</tr>
<?php endforeach;
}
 else
 {
		foreach($follow as $name):?>
	<tr>
	<td><?php echo $this->Html->link(__($name['Follow']['following_name']),array('controller'=>'Posts','action'=>'user_posts',$name['Follow']['following_id']));?></td>
	</tr>
<?php endforeach;
 }?>

</table>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
	</ul>
</div>
