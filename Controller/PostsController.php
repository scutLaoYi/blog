<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 * ----------------------------------------------
 * 博文模块
 * 该模块提供了基本的博文增删改功能
 * 所有访问网站的用户均可浏览博客内容
 * 已登录用户具有权限编写新的博文
 * 已登录用户具有权限管理自己的博文（删除、修改等）
 * 管理员具有所有权限
 */
class PostsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Post', 'Commet','User','Follow');

/**
 * index method
 * 博文主页，按时间显示所有的博文列表
 * 
 */
	public function index() {
		$this->Post->recursive = 1;
		$this->Paginator->settings = array('limit' => '6');
		$data = $this->Paginator->paginate('Post');
		foreach($data as $da)
		{
			$user_id=$da['Post']['user_id'];
			if($follow=$this->Follow->find('first',array('conditions'=>array('following_id'=>$user_id,'follower_id'=>$this->Auth->user('id')))))
			{
				$is_follow[$user_id]=$follow['Follow']['id'];
			}
			else
			{
				$is_follow[$user_id]='-1';
			}
		}
		$this->set('posts',$data);
		$this->set('is_follow',$is_follow);
	}

	/*
	 * user_posts函数
	 * 显示对应user_id的所有博文列表
	 * 检测对应的user_id是否存在，查找数据库并将该用户的所有博文数据列表显示
	 * 检测当前用户是否有权限管理（当前用户id与显示的user_id相同，或者当前用户为管理员)
	 * 为有权限编辑的用户提供编辑接口("is_current_user"属性设置为true)
	 */
	public function user_posts($user_id = null)
	{
		if(!$user_id)
		{
			$user_id = $this->Auth->user('id');
		}
		
		$data = $this->Paginator->paginate('Post', array('Post.user_id' => $user_id));
		$this->set('posts', $data);
		$this->set('is_current_user', $this->Auth->user('role') === 'admin' || $this->Auth->user('id') == $user_id);
		$this->set('posts_owner', $this->User->find('first',array(
			'conditions'=>array('User.id'=>$user_id),
			'filed'=>array('User.username','User.id'),
		
		)));
	}

/**
 * view method
 *
 * 博文显示页面
 * 获取博文id，构造SQL语句查询数据库，得到博文内容
 * 根据博文id，构造SQL语句查询评论列表，并得到对应该博文的评论内容
 * 
 */
	public function view($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
		$currentPost = $this->Post->find('first', $options);
		$this->set('post', $currentPost);
		$commetOpt = array('conditions' => array('Commet.post_id' => $id));
		$this->set('commets', $this->Commet->find('all', $commetOpt));
		$user_id=$currentPost['Post']['user_id'];
		$authod = $this->User->find('first',array(
			'fileds'=>array('username'),
			'conditions'=>array('User.id'=>$user_id)
		));
		$this->set('authod',$authod);
	}

/**
 * add method
 * 博文增加页面
 * 将用户id写入博文数据记录中，并写入数据库
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Post']['user_id'] = 
				$this->Auth->user('id');
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 * 博文编辑页面
 * 检测博文是否存在
 * 检测用户是否有权限管理该博文
 * 接收用户Post过来的请求并对相应博文内容进行更新
 *
 */
	public function edit($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
			$this->request->data = $this->Post->find('first', $options);
		}
	}

/**
 * delete method
 * 删除博客内容
 * 检验博客是否存在
 * 检验用户是否有权限管理该博客（拥有者或管理员）
 * 删除后跳转回博客首页
 */
	public function delete($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Post->delete()) {
			$this->Session->setFlash(__('The post has been deleted.'));
		} else {
			$this->Session->setFlash(__('The post could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	/*
	 * beforeFilter函数
	 * 权限管理，在beforeFilter函数中授权的页面不用登录即可访问
	 * 未登录用户可以浏览博客，但不允许其他任何操作
	 */
	public function beforeFilter()
	{
		$this->Auth->allow('index', 'view');
		return parent::beforeFilter();
	}


	/*
	 * isAuthorized函数
	 * 权限管理，在该函数中可以启用基于RBAC的角色访问控制
	 * 登录用户可以新增博文，显示用户所有博文
	 * 用户可以进入自己的博文管理页面，增删改
	 */
	public function isAuthorized($user)
	{
		
		if(in_array($this->action, array('add', 'user_posts','view')))
		{
			return true;
		}

		if(in_array($this->action, array('edit', 'delete')))
		{
			$postId = $this->request->params['pass'][0];
			if($this->Post->isOwnedBy($postId, $user['id']))
			{
				return true;
			}
		}

		return parent::isAuthorized($user);
	}
}

