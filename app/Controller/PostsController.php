<?php

class PostsController extends AppController {


     public $helpers = array('Html', 'Form');
	 
	 public function index() {
	   $this->set('post', $this->Post->find('all'));
	   
	   }
	   
}

?>