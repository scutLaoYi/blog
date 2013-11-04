<?php
/*
class User extends AppModel
{
	public $validate = array(
			'username' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'A username is needed'
					)
				),
			'password' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'A password is needed'
					)
				),
			'role' => array(
				'valid' => array(
					'rule' => array('inList',array('admin','author')),
					'message' => 'szy fuck you!',
					'allowEmpty' => false
					)
				)
				);
}
*/

class User extends AppModel {
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );
}
?>

