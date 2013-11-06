<div class="posts index">
	<h2><?php echo __('博文目录'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td><?php echo $this->Html->link(__($post['Post']['title']), array('action' => 'view', $post['Post']['id'])); ?>&nbsp;</td>
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
		<li><?php echo $this->Html->link(__('写博客'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('我的博客'), array('action' => 'my_posts')) ?></li>
	</ul>
</div>
