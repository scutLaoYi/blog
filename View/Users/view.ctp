<!--<div class="action_list">
	<h3><?php echo __('头像'); ?></h3>
		<?php 
			echo $this->Html->image('../head_image/'.$user['User']['image'], array('width' => '300', 'height'=>'300'));
		?>
<?php
		if($flag)
		{
			echo $this->Form->create('Head', array('type'=>'file'));
			echo $this->Form->input('head_image', array('type'=>'file'));
			echo $this->Form->end('提交新头像');

		}
		?>
</div>-->
<div class="info">
	<h3><?php echo __('头像'); ?></h3>
		<?php 
			echo $this->Html->image('../head_image/'.$user['User']['image'], array('width' => '300', 'height'=>'300'));
		?>
<?php
		if($flag)
		{
			echo $this->Form->create('Head', array('type'=>'file'));
			echo $this->Form->input('head_image', array('type'=>'file'));
			echo $this->Form->end('提交新头像');

		}
		?>
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
	
		<div class="button"><?php echo $this->Html->link(__('博文列表'),array('controller'=>'Posts','action'=>'user_posts',$user['User']['id'])); ?> &nbsp;</div>
		<div class="button"><?php 
			if($flag){ 
			echo $this->Html->link(__('修改密码'),array('controller'=>'Users','action'=>'edit',$user['User']['id']));
			} else {
				if($is_follow=='-1')
				{
					echo $this->Html->link('关注',array('controller'=>'Follows','action'=>'add',$user['User']['id'],$user['User']['username']));
				}
				else
				{
					echo $this->Html->link('取消关注',array('controller'=>'Follows','action'=>'delete',$is_follow));
				}
			}
				 ?> &nbsp;
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

