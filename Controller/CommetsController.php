<?php
App::uses('AppController', 'Controller');
/**
 * Commets Controller
 *
 * 评论模块
 * 该模块提供了对博文的评论功能
 * 已登录用户拥有权限针对某个博文内容编写评论
 * 评论写入数据库后，在对应博文的显示页面中可连带显示对该博文的评论列表
 * 管理员有权限编辑和删除所有存在的评论
 */
class CommetsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 * 所有评论的列表显示页面
 * 用于后台管理员查找管理评论
 */
	public function index() {
		$this->Commet->recursive = 0;
		$this->set('commets', $this->Paginator->paginate());
	}

/**
 * view method
 * 显示某条评论
 * 管理员使用的管理页面
 * 前台显示则将评论与对应的博文联系并做列表显示
 * 没有特定评论的单一显示页面
 */
	public function view($id = null) {
		if (!$this->Commet->exists($id)) {
			throw new NotFoundException(__('Invalid commet'));
		}
		$options = array('conditions' => array('Commet.' . $this->Commet->primaryKey => $id));
		$this->set('commet', $this->Commet->find('first', $options));
	}

/**
 * add method
 * 评论添加页面
 * 获取当前用户的id，获取参数post_id确定针对的博文id
 * 写入数据库并做对应的跳转处理
 */
	public function add($post_id) {
		if ($this->request->is('post')) {
			$this->Commet->create();
			$this->request->data['Commet']['user_id']= $this->Auth->user('id');
			$this->request->data['Commet']['post_id'] = $post_id;
			$this->request->data['Commet']['user_name'] = $this->Auth->user('username');
			if ($this->Commet->save($this->request->data)) {
				$this->Session->setFlash(__('The commet has been saved.'));
				return $this->redirect(array('controller'=>'Posts','action' => 'view', $post_id));
			} else {
				$this->Session->setFlash(__('The commet could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 * 编辑评论页面
 * 管理员使用的后台管理页面
 *
 */
	public function edit($id = null) {
		if (!$this->Commet->exists($id)) {
			throw new NotFoundException(__('Invalid commet'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Commet->save($this->request->data)) {
				$this->Session->setFlash(__('The commet has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commet could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Commet.' . $this->Commet->primaryKey => $id));
			$this->request->data = $this->Commet->find('first', $options);
		}
	}

/**
 * delete method
 * 删除某条评论
 * 管理员使用的后台管理页面
 */
	public function delete($id = null) {
		$this->Commet->id = $id;
		if (!$this->Commet->exists()) {
			throw new NotFoundException(__('Invalid commet'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Commet->delete()) {
			$this->Session->setFlash(__('The commet has been deleted.'));
		} else {
			$this->Session->setFlash(__('The commet could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/*
	 * 用户权限管理
	 * 只有登录用户允许发送新的评论
	 */
	public function isAuthorized($user)
	{
		if(in_array($this->action, array('add')))
		{
			return true;
		}
		return parent::isAuthorized($user);
	}
}
