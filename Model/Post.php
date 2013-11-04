<?php

class Post extends AppModel
{
	public function isOwnedBy($post, $user)
	{
		return $this->filed('id', array('id'=>$post, 'user_id'=>$user)
			=== $post);
	}
}

?>
