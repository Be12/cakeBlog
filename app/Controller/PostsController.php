<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form');
	
	public function index() {
	//finding all the records in the Post table and handing the response to the index.ctp //
        $this->set('posts', $this->Post->find('all'));
		}
		public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    
    }
	
	
	//This function allows us to post to the database //
	 public function add() {
	 
	 //this checks if this is a HTTP request//
        if ($this->request->is('post')) {
		//initialising the Post Model//
            $this->Post->create();
			// handing the request object data to be saved by the Post Model
            if ($this->Post->save($this->request->data)) {
			// confirmation message//
                $this->Session->setFlash(__('Your post has been saved.'));
				// redirecting the Posts index action //
                return $this->redirect(array('action' => 'index'));
            }
			// display error message
            $this->Session->setFlash(__('Unable to add your post.'));
        }
	}

	//This function allows us to add to the posts database
		public function edit($id = null) {
    if (!$id) {
        throw new NotFoundException(__('Invalid post'));
    }

    $post = $this->Post->findById($id);
    if (!$post) {
        throw new NotFoundException(__('Invalid post'));
    }

    if ($this->request->is(array('post', 'put'))) {
        $this->Post->id = $id;
        if ($this->Post->save($this->request->data)) {
            $this->Session->setFlash(__('Your post has been updated.'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Unable to update your post.'));
    }

    if (!$this->request->data) {
        $this->request->data = $post;
    }
	
	}
	
    //function will allow us to edit an existing post
	public function delete($id) {
	
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Post->delete($id)) {
        $this->Session->setFlash(
            __('The post with id: %s has been deleted.', h($id))
        );
        return $this->redirect(array('action' => 'index'));
    }
	
	}
	
	public function add() {
    if ($this->request->is('post')) {
        //Added this line
        $this->request->data['Post']['user_id'] = $this->Auth->user('id');
        if ($this->Post->save($this->request->data)) {
            $this->Session->setFlash(__('Your post has been saved.'));
            return $this->redirect(array('action' => 'index'));
        }
    }
  }
	
  public function isAuthorized($user) {
    // All registered users can add posts
    if ($this->action === 'add') {
        return true;
    }

    // The owner of a post can edit and delete it
    if (in_array($this->action, array('edit', 'delete'))) {
        $postId = $this->request->params['pass'][0];
        if ($this->Post->isOwnedBy($postId, $user['id'])) {
            return true;
        }
    }

    return parent::isAuthorized($user);
	
    }	
}
?>