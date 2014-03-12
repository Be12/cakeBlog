<?php

// app/Controller/UsersController.php
class UsersController extends AppController {

       // every body is allowed a user
	   
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add'); // class, methods, allow function
    }

	   // the model that relates go and do recursive doent go down to the next users
	   
    public function index() { // Default ctp page
        $this->User->recursive = 0;
        $this->set('users', $this->paginate()); // next page or block of records
    }

	   // the model looks for a record but can not find brake out if it finds a record hand over to the view
	   
    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id)); // the view read this user record
    }
	
	   // Must come via a Post request like a Form

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) { // save the request object to the Holder ( Defined as a class )
			
			// will create the box to display this flash message any where on the screen to update the user
			
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index')); // go there ( Default to its own Controller ) implement the function index if correct
				
            }
			
			// if does not work display message to user
			
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

	// go to the database and find a user by id
	
    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) { // brake out if you can not find the user
            throw new NotFoundException(__('Invalid user'));
        }
		
		// accesses the request if not sure go to unset function or if the request is valid go to if request function
		
        if ($this->request->is('post') || $this->request->is('put')) { //              or
            if ($this->User->save($this->request->data)) { // saved the data from the foam
                $this->Session->setFlash(__('The user has been saved')); // the information is saved
                return $this->redirect(array('action' => 'index')); // return to the index
            }
            $this->Session->setFlash( // display a message to the user
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->read(null, $id); // found the user via a get request
            unset($this->request->data['User']['password']); // get the details from the user but unset the password
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
		
		// display a message to the user
		
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
		
		public function beforeFilter() {
        parent::beforeFilter();
		
        // Allow users to register and logout.
		
        $this->Auth->allow('add', 'logout');
		
        }

        public function login() {
        if ($this->request->is('post')) {
        if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirect());
			
        }
		
        $this->Session->setFlash(__('Invalid username or password, try again'));
		
        }
        }

        public function logout() {
        return $this->redirect($this->Auth->logout());
		
        }
		
    }

}
















































?>