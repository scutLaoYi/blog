<?php
App::uses('AppController', 'Controller');
/**
 * Follows Controller
 * -------------------------------------
 * 关注模块
 * 该模块用于提供用户对用户的关注功能
 * 用户可以增加或删除对某个其他用户的关注
 * 用户的关注列表会显示在用户的信息中
 * 用户通过关注列表可以直接查看对应用户的所有博文信息
 */
class FollowsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('User','Follow');
	public $components = array('Paginator');

/**
 * index method
 * 显示所有关注的关系列表
 * 用于管理员后台管理功能
 */
	public function index() {
		$this->Follow->recursive = 0;
		$this->set('follows', $this->Paginator->paginate());
	}


/*
 * add method
 * 增加关注关系
 * 
 * 获取当前用户的id作为follower_id
 * 获取目标用户的id作为following_id
 * 获取目标用户的name作为following_name
 * 检测两个id是否相同，若相同说明用户试图关注自己，拒绝该操作
 * 检测当前关注关系是否存在，存在说明已关注该用户，拒绝重复关注操作并做对应跳转
 * 排除异常情况后将关注关系写入数据库
 */
	public function add($following_id = null,$following_name = null) {		
			$this->Follow->create();
			$this->request->data['Follow']['following_id'] = $following_id;
			$this->request->data['Follow']['follower_id'] = $this->Auth->user('id');
			$this->request->data['Follow']['following_name'] = $following_name;
			if($this->Auth->user('id')==$following_id)
			{
				$this->Session->setFlash('不能关注自己');
			}
			else	if($judge = $this->Follow->find('first',array(
			'conditions'=>array('follower_id'=>$this->Auth->user('id'),'following_id'=>$following_id)))
			)
			{
				$this->Session->setFlash('你已经关注该用户，不能重复关注');
			}else
			{
				if ($this->Follow->save($this->request->data)) {
					$this->Session->setFlash(__('The follow has been saved.'));
				
				} else {
					$this->Session->setFlash(__('The follow could not be saved. Please, try again.'));
				}
			}
			return $this->redirect($this->referer());
		
	}

/**
 * edit method
 * 编辑关注关系
 * 管理员使用的后台管理页面
 * 可针对性编辑修改某一个关注关系的所有数据
 */
	public function edit($id = null) {
		if (!$this->Follow->exists($id)) {
			throw new NotFoundException(__('Invalid follow'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Follow->save($this->request->data)) {
				$this->Session->setFlash(__('The follow has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The follow could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Follow.' . $this->Follow->primaryKey => $id));
			$this->request->data = $this->Follow->find('first', $options);
		}
	}

/**
 * delete method
 * 删除关注关系
 * 传入关注关系的id并做删除操作
 */
	public function delete($id = null) {
		$this->Follow->id = $id;
		if (!$this->Follow->exists()) {
			throw new NotFoundException(__('Invalid follow'));
		}
		if ($this->Follow->delete()) {
			$this->Session->setFlash(__('The follow has been deleted.'));
		} else {
			$this->Session->setFlash(__('The follow could not be deleted. Please, try again.'));
		}
			return $this->redirect($this->referer());
	}


	/*
	 * 用户权限管理
	 * 已登录用户允许关注、解除关注
	 * 未登录用户不允许操作关注功能
	 */
	public function isAuthorized($user)
	{
		if(in_array($this->action,array('delete','edit','add')))
		{
			return true;
		}
		return parent::isAuthorized($user);
	}
}
