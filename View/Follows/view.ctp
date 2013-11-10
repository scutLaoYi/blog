<div class="follows view">
<h2><?php  echo $username.'关注列表'; ?></h2>
<table cellpadding="0" cellspacing="0">
<?php if($flag)
{
	 foreach($follow as $name):?>
	<tr>	
	<td><?php echo $this->Html->link(__($name['Follow']['following_name']),array('controller'=>'Posts','action'=>'use_posts',$name['Follow']['following_id']));?></td>
	<td><?php echo $this->Html->link('取消关注',array('action'=>'delete',$name['Follow']['id']));?> </td>
	</tr>
<?php endforeach;
}
 else
 {
		foreach($follow as $name):?>
	<tr>
	<td><?php echo $this->Html->link(__($name['Follow']['following_name']),array('controller'=>'Posts','action'=>'use_posts',$name['Follow']['following_id']));?></td>
	</tr>
<?php endforeach;
 }?>

</table>
</div>

