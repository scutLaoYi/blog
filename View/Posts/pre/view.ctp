<div class="info">
<div class="button"><h2><?php echo $this->Html->link('Blog List', array('action'=>'index')) ?></h2></div>
<div class="button"><h2><?php echo $this->Html->link($authod['User']['username'].'的博文', array('action' => 'user_posts', $post['Post']['user_id']));?> </h2></div>

<p>标题</p>
<h2><?php echo $post['Post']['title']; ?> </h2>

<p>内容</p>
<?php
$message = ereg_replace("\n", "<BR>\n", $post['Post']['body']);
echo "<p>$message</p>";
?>
</div>

<div class="comment">
<p>评论列表：</p>
<?php
foreach ($commets as $commet):
?>
<p><?php 
echo '用户'.$commet['Commet']['user_name'] . ':' . '<br \>';
echo $commet['Commet']['content'];?></p>
<?php
endforeach;
?>

<?php echo $this->Html->link('添加评论', array('controller'=>'commets', 'action'=>'add',$post['Post']['id'])); ?>
</div>
