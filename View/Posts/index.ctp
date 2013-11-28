<!-- posts index -->
<div class="content">
	<h2><?php echo __('博文目录'); ?></h2>
		<div class="button pill">
		<a><?php echo $this->Html->link('写博客', array('action' => 'add')); ?></a>
		</div>
		<div class="button pill">
		<a><?php echo $this->Html->link('我的博客', array('action' => 'user_posts')) ?></a>
		</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo '标题'; ?></th>
			<th><?php echo '作者'; ?></th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td><a><?php echo $this->Html->link(__($post['Post']['title']), array('action' => 'view', $post['Post']['id'])); ?>&nbsp;</a></td>
		<td><?php echo $this->Html->link(__($post['User']['username']), array('action'=>'user_posts', $post['Post']['user_id'])); ?> &nbsp; </td>
	</tr>
<?php endforeach; ?>
	</table>
	<!--<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('第{:page}页 共{:pages}页, 显示{:current}条记录, 共{:count}条记录')
	));
	?>	</p>-->
	<div class="paging">
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('第{:page}页 共{:pages}页, 显示{:current}条记录, 共{:count}条记录')
	));
	?>
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
