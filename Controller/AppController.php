<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 * --------------------------------------------------------------------------------
 * AppController
 * 所有Controller的基类
 * 在此类中定义了所有Controller所需要的通用模块（Auth用户认证模块）
 * 并授权管理员对所有页面具有完全的访问权限
 */
class AppController extends Controller {
	public $components = array(
			'Session',
			'Auth' => array(
				'loginRedirect' => array('controller' => 'posts','action' => 'index'),
				'logoutRedirect' => array('controller' => 'pages','action' => 'index', 'home'),
				'authorize' => array('Controller')
				)
			);

	public function isAuthorized($user)
	{
		if(isset($user['role']) && $user['role'] === 'admin')
		{
			return true;
		}
		return false;
	}

	public function beforeFilter()
	{
		$this->Auth->allow('index','logout');
	}
}

