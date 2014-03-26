<?php
class Post extends AppModel{

    // make sure that no empty Posts are added
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id')
	);
	
	public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );

	public function isOwnedBy($post, $user) {
    	return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
	}
}
?>