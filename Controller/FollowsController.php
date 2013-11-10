<?php
App::uses('AppController', 'Controller');
/**
 * Follows Controller
 *
 * @property Follow $Follow
 * @property PaginatorComponent $Paginator
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
 *
 * @return void
 */
	public function index() {
		$this->Follow->recursive = 0;
		$this->set('follows', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

/*
 * add method
 *
 * @return void
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
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
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
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Follow->id = $id;
		if (!$this->Follow->exists()) {
			throw new NotFoundException(__('Invalid follow'));
		}
	//	$this->request->onlyAllow('post', 'delete');
		if ($this->Follow->delete()) {
			$this->Session->setFlash(__('The follow has been deleted.'));
		} else {
			$this->Session->setFlash(__('The follow could not be deleted. Please, try again.'));
		}
			return $this->redirect($this->referer());
	}
	public function isAuthorized($user)
	{
		if(in_array($this->action,array('delete','edit','add')))
		{
			return true;
		}
		return parent::isAuthorized($user);
	}
}
