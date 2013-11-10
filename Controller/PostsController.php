<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
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
 *
 * @return void
 */
	public function index() {
		$this->Post->recursive = 1;
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

/*	public function list_all()
	{
		$this->Post->recursive = 0;
		$this->set('posts', $this->Paginator->paginate());
	}
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
 * @throws NotFoundException
 * @param string $id
 * @return void
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
 *
 * @return void
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
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
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
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
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

