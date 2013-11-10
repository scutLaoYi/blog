<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Html', 'Form');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('User','Follow');

/**
 * index method
 *
 * @return void
 */
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	public function login()
	{
		if($this->request->is('post'))
		{
			if($this->Auth->user('id'))
			{
				$this->Session->setFlash(__('You have been logined,you have no need to do that again.'));
				return $this->redirect(array('controller' => 'Posts','action' => 'index'));
			}
			if($this->Auth->login())
			{
				//return $this->redirect($this->Auth->redirect());
				$this->Session->write('user',$this->data['User']['username']);
				return $this->redirect(array('controller' => 'Posts','action' => 'index'));
			}
			$this->Session->setFlash(__('Invalid username or password,please try again.'));
		}
	}

	public function logout()
	{
		$this->Session->delete('user');
		$this->Auth->logout();
		return $this->redirect(array('controller' => 'Posts','action' => 'index'));
	//	return $this->redirect($this->Auth->logout());
	}

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
		$this->pageTitle = "login and register";
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		//if (!$this->User->exists($id)) {
		//	
		//	throw new NotFoundException(__('Invalid user'));
		//}
		if($id==null)
		$id=$this->Auth->user('id');
		if($this->Auth->user('id')==$id)
			$flag=true;
		else $flag=false;
		$this->set('flag',$flag);	
		if($follows=$this->Follow->find('first',array('conditions'=>array('follower_id'=>$this->Auth->user('id'),'following_id'=>$id))))
		{
			$is_follow=$follows['Follow']['id'];
		}
		else $is_follow='-1';
		$this->set('is_follow',$is_follow);
		$options=$this->Follow->find('all',array('conditions'=>array('follower_id'=>$id)));
		$this->set('follow', $options);
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
		$this->set('pa',$this->Paginator->paginate());
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function isAuthorized($user)
	{
		
		if(in_array($this->action, array('view')))
		{
			return true;
		}
		return parent::isAuthorized($user);
	}
}
