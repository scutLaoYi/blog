<?php echo $this->Html->link('博文沐浴露', array('action'=>'index')) ?>
<h1><?php echo $post['Post']['title']; ?> <h1>
<?php
$message = ereg_replace("\n", "<BR>\n", $post['Post']['body']);
echo "<p>$message</p>";
?>
