<div class="posts list">
	<h2><?php echo __('博文目录'); ?> </h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('title');?></th>
	</tr>
	<?php foreach($posts as $post): ?>
	<tr>
		<th><?php echo $this->Html->link(__($post['Post']['title']), array('action' => 'view', $post['Post']['id'])); ?></th>
	</tr>
	<?php endforeach; ?>
	</table>
	<p>
	<?php 
echo $this->Paginator->counter(array('format' => __('第{:page}页，共有 {:pages}页, 每页显示{:count}条记录')));
	?>
	</p>
	<div class="paging">
	<?php	
echo $this->Paginator->prev('上一页', array(), null, array('class'=>'prev disabled'));
echo $this->Paginator->numbers(array('separator'=>''));
echo $this->Paginator->next('下一页', array(), null, array('class'=>'next disabled'));
	?>
	</div>
</div>
