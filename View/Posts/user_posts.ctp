<div class="posts index">
	<h2><?php echo __($posts_owner['User']['username'].'的博客'); ?></h2>
	<?php
	if($is_follow=='-1')
	{
	echo $this->Html->link('关注',array('controller'=>'Follows','action'=>'add',$posts_owner['User']['id'],$posts_owner['User']['username']));
	}
	else
	{
	echo $this->Html->link('取消关注',array('controller'=>'Follows','action'=>'delete',$is_follow));
	}
	?>&nbsp;&nbsp;&nbsp;
	<?php
	if(!$flag)
		echo $this->Html->link('他的关注列表',array('controller'=>'Follows','action'=>'view',$posts_owner['User']['id']));
	else
		echo $this->Html->link('我的关注列表',array('controller'=>'Follows','action'=>'view',$posts_owner['User']['id']));
	?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('body'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($post['Post']['title'], array('action' => 'view', $post['Post']['id'])); ?> </td>
		<td><?php echo h($post['Post']['body']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php if ($is_current_user)
					{
			?>
			<?php echo $this->Html->link(__('查看'), array('action' => 'view', $post['Post']['id'])); ?>
			<?php echo $this->Html->link(__('编辑'), array('action' => 'edit', $post['Post']['id'])); ?>
			<?php echo $this->Form->postLink(__('删除'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
			<?php
					}
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('第{:page}页 共{:pages}页, 显示{:current}条记录, 共{:count}条记录')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('操作'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('返回博客列表'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('写博客'), array('action' => 'add')); ?></li>
	</ul>	
</div>
