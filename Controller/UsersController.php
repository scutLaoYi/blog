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
			$oldPassword = $this->User->find('first',array('conditions' => array('User.id' => $id)));
			if(AuthComponent::password($this->request->data['User']['old password']) == $oldPassword['User']['password'])
			{
				if($this->request->data['User']['new password'] == $this->request->data['User']['confirm new password'])
				{
					$newData['id'] = $this->Auth->user('id');
					$newData['username'] = $this->Auth->user('username');
					$newData['password'] = $this->request->data['User']['new password'];
					$newData['role'] = $this->Auth->user('role');
					if ($this->User->save($newData)) {
						$this->Session->setFlash(__('The user has been saved.'));
						return $this->redirect(array('controller'=>'Users','action' => 'view',$id));
					} else {
						$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
					}
				}
				else
				{
					$this->Session->setFlash(__('please confirm your new password again.'));
	                                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			                $this->request->data = $this->User->find('first', $options);

				}
			} else {
				$this->Session->setFlash(__('You old password is wrong,please try again.'));
				$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
				$this->request->data = $this->User->find('first', $options);
			}
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
		
		if(in_array($this->action, array('view','edit')))
		{
			return true;
		}
		
		return parent::isAuthorized($user);
	}
}
