<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 * ---------------------------------------
 * 用户管理模块
 * 该模块提供了对博客平台用户的所有管理操作
 * 其他所有模块依赖于该模块的用户权限
 * 通过该模块可以完成新用户的注册、登录、登出等操作
 * 用户登录后在权限管理器Auth(内置模块)中写入信息，在其他页面的控制器中直接调用并获取当前用户的登录信息
 * 
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


	/*
	 * 登录函数
	 * 检测当前是否已经登录，是则直接跳转到主页
	 * 调用验证器检测用户的登录信息(username, password)是否正确
	 * 如果登录成功，在cookie中写入当前用户的username供页面显示使用（只供显示，不提供验证功能）
	 * 给出登录信息并作相应跳转处理
	 */
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
				$this->Session->write('user',$this->data['User']['username']);
				return $this->redirect(array('controller' => 'Posts','action' => 'index'));
			}
			$this->Session->setFlash(__('Invalid username or password,please try again.'));
		}
	}

	/*
	 * 登出函数
	 * 删除对应的cookie
	 * 调用验证器完成登出操作
	 * 跳转到主页面
	 */
	public function logout()
	{
		$this->Session->delete('user');
		$this->Auth->logout();
		return $this->redirect(array('controller' => 'Posts','action' => 'index'));
	}

	/**
	 * index method
	 *
	 * 管理员使用的用户列表页面
	 * 显示所有用户的列表
	 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
		$this->pageTitle = "login and register";
	}

/**
 * view method
 * 用户信息显示页面
 * 显示某个用户的基本信息
 */
	public function view($id = null) {
		//若传入的id为空，则直接读取当前用户的id
		if($id==null)
			$id=$this->Auth->user('id');
		//若是当前用户，则提供编辑接口
		if($this->Auth->user('id')==$id)
			$flag=true;
		else
		   	$flag=false;

		$this->set('flag',$flag);	
		//检测当前登录用户是否有关注该显示用户
		if($follows=$this->Follow->find('first',array('conditions'=>array('follower_id'=>$this->Auth->user('id'),'following_id'=>$id))))
		{
			$is_follow=$follows['Follow']['id'];
		}
		else $is_follow='-1';
		$this->set('is_follow',$is_follow);
		
		//获取当前用户的关注列表
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
		//
		//用户提交头像的处理
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
 * 用户注册函数
 * 获取用户输入的表单，调用模型层验证用户输入数据
 * 写入数据库
 * 做相应跳转处理
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('controller'=>'Posts', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 * 修改密码的函数
 * 提交用户的表单进行验证
 * 检测是否输入了正确的原始密码
 * 检测是否输入两次相同的新密码
 * 存入数据
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			//获取数据库中的原始密码
			$oldPassword = $this->User->find('first',array('conditions' => array('User.id' => $id)));
			//若数据的原始密码正确则进行密码修改操作
			if(AuthComponent::password($this->request->data['User']['old password']) == $oldPassword['User']['password'])
			{
				//检测是否输入两次密码相同
				if($this->request->data['User']['new password'] == $this->request->data['User']['confirm new password'])
				{
					//写入新数据
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
					//输入两次新密码不同，不予修改
					$this->Session->setFlash(__('please confirm your new password again.'));
					$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
					$this->request->data = $this->User->find('first', $options);

				}
			//用户输入的原始密码错误，不予修改
			} else {
				$this->Session->setFlash(__('You old password is wrong,please try again.'));
				$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
				$this->request->data = $this->User->find('first', $options);
			}
		}
	}

/**
 * delete method
 * 删除用户的操作
 * 管理员使用
 * 提交对应用户的id，执行删除操作
 * 调用SQL语句删除数据库中的对应表项
 *
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

	/*
	 * 用户权限管理
	 * 允许登录用户管理自己的信息
	 */
	public function isAuthorized($user)
	{
		
		if(in_array($this->action, array('view','edit')))
		{
			return true;
		}
		
		return parent::isAuthorized($user);
	}

	/*
	 * beforeFilter
	 * 允许未登录用户访问add页面注册新用户
	 */
	public function beforeFilter()
	{
		$this->Auth->allow('add');
		parent::beforeFilter();
	}
}
