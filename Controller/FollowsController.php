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
	public function view($id = null) {
		if (!$this->Follow->exists($id)) {
			throw new NotFoundException(__('Invalid follow'));
		}
		$options = array('conditions' => array('Follow.' . $this->Follow->primaryKey => $id));
		$this->set('follow', $this->Follow->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($following_id = null,$following_name = null) {
		if ($this->request->is('post')) {
			$this->Follow->create();
			$this->request->data['Follow']['following_id'] = $following_id;
			$this->request->data['Follow']['follower_id'] = $this->Auth->user('id');
			$this->request->data['Follow']['following_name'] = $following_name;
			if ($this->Follow->save($this->request->data)) {
				$this->Session->setFlash(__('The follow has been saved.'));
				return $this->redirect(array('controller' => 'Users','action' => 'view',$following_id));
			} else {
				$this->Session->setFlash(__('The follow could not be saved. Please, try again.'));
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
		return $this->redirect(array('controller'=>'Users','action' => 'view',$this->Auth->user('id')));
	}}
