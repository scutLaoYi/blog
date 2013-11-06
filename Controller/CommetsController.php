<?php
App::uses('AppController', 'Controller');
/**
 * Commets Controller
 *
 * @property Commet $Commet
 * @property PaginatorComponent $Paginator
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
 *
 * @return void
 */
	public function index() {
		$this->Commet->recursive = 0;
		$this->set('commets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
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
 *
 * @return void
 */
	public function add($user_id, $post_id) {
		if ($this->request->is('post')) {
			$this->Commet->create();
			$this->request->data['Commet']['user_id']= $user_id;
			$this->request->data['Commet']['post_id'] = $post_id;
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
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
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
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
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
	}}
