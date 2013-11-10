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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		//changed by laoyi. get the current User, used in the following code.
		$currentUser = $this->User->find('first', $options);
		$this->set('user', $currentUser);

		$optionsFollow = array('conditions' => array('Follow.follower_id' => $id));
		$this->set('pa',$this->Paginator->paginate());
		$this->set('follows', $this->Follow->find('all',$optionsFollow));

		//----------------------------------------
		//by laoyi: adding the function to save and display image.

		if(!empty($currentUser['User']['image']))
		{
			$this->set('image', $currentUser['User']['image']);
		}
		if($this->request->is('post'))
		{
			if(!empty($this->request->data))
			{
				$file = $this->data['Head']['head_image'];

				$ext = substr(strtolower(strrchr($file['name'], '.')), 1);
				$arr_ext = array('jpg', 'jpeg', 'gif', 'png');

				if(in_array($ext, $arr_ext))
				{
					move_uploaded_file($file['tmp_name'], WWW_ROOT.'head_image/'.$file['name']);
					$currentUser['User']['image'] = $file['name'];
				}
			}
			if($this->User->save($currentUser))
			{
				$this->Session->setFlash('头像上传成功！');
				$this->redirect($this->referer());
			}
			else
			{
				$this->Session->setFlash('头像上传失败...');
			}
		}
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
	}}
