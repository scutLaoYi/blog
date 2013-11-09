<?php

class Post extends AppModel
{
	public $hasmany='Commet';
	public $belongsTo='User';
	public function isOwnedBy($post, $user)
	{
		return $this->field('id', array('id'=>$post, 'user_id'=>$user))=== $post;
	}
}

?>
