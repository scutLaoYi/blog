<?php echo $this->Html->link('博文沐浴露', array('action'=>'index')) ?>
<h2><?php echo $post['Post']['title']; ?> </h2>
<h1><?php echo $this->Html->link($authod['User']['username'].'的所有博文', array('action' => 'user_posts', $post['Post']['user_id']));?> </h1>

<?php
$message = ereg_replace("\n", "<BR>\n", $post['Post']['body']);
echo "<p>$message</p>";
?>
<p>---------------------------------------------------------------</p>
<p>评论列表：</p>
<?php
foreach ($commets as $commet):
?>
<p><?php 
echo '用户'.$commet['Commet']['user_name'] . ':';
echo $commet['Commet']['content'];?></p>
<?php
endforeach;
?>

<?php echo $this->Html->link('添加评论', array('controller'=>'commets', 'action'=>'add',$post['Post']['id'])); ?>
