<?php echo $this->Html->css('myCss'); ?>
<div class="action_list">
<ul>
	<div class="button"><?php echo $this->Html->link('Blog List', array('action'=>'index')) ?></div>
	<div class="button"><?php echo $this->Html->link($authod['User']['username'].'的博文', array('action' => 'user_posts', $post['Post']['user_id']));?>
</ul>
</div>

<div class="component">
	<?php
echo $this->Html->css(array('normalize','demo','book'));
echo $this->Html->script('modernizr.custom');
?>
	<ul class="align">
		<li>
			<figure class='book'>
				<ul class='hardcover_front'>
					<li>
						<div class="coverDesign yellow">
							<span class="ribbon">Blog</span>
							<p>内容</p>
						</div>
					</li>
					<li></li>
				</ul>
				<ul class='page'>
					<li></li>
					<li>
						<p>title</p>
						<h2><?php echo $post['Post']['title'];?></h2>
						<p>content</p>
						<?php $message=ereg_replace("\n","<BR>\n",$post['Post']['body']);
						echo "<p>$message</p>";?>
					</li>
					<li></li>
					<li></li>
				</ul>
				<ul class='harcover_back'>
					<li></li>
				</ul>
				<ul class='book_spine'>
					<li></li><li></li><li></li><li></li>
				</ul>
			</figure>
		</li>
<li>
			<figure class='book'>
				<ul class='hardcover_front'>
					<li>
						<div class="coverDesign blue">
							<p>评论</p>
						</div>
					</li>
					<li></li>
				</ul>
				<ul class='page'>
					<li></li>
					<li>
						<h2>评论列表</h2>
						<?php foreach ($commets as $commet): ?>
						<h2><?php 
						echo '用户'.$commet['Commet']['user_name'] . ':' . '<br \>';?></h2>
						<p><?php echo $commet['Commet']['content'];?></p>
						<?php endforeach;?>
						<div class="button"><?php echo $this->Html->link('添加评论', array('controller'=>'commets', 'action'=>'add',$post['Post']['id'])); ?></div>
					</li>
					<li></li>
					<li></li>
				</ul>
				<ul class='harcover_back'>
					<li></li>
				</ul>
				<ul class='book_spine'>
					<li></li><li></li><li></li><li></li>
				</ul>
			</figure>
		</li>
	</ul>
</div>


