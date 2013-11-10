<?php
/**
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'ndsc blog');

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, array('controller'=>'Posts','action'=>'index')); ?></h1>
		</div>
		<div id="menubar">
 			<ul id="menu">
			<li><?php echo $this->Html->link('主页', array('controller'=>'Posts', 'action'=>'index')); ?></li>
			  <li><a href="">个人信息</a>
				<ul>
				<li><?php echo $this->Html->link('个人信息管理',array('controller'=>'Users', 'action'=>'view')); ?></li>
				<li><?php echo $this->Html->link('我的博客',array('controller'=>'Posts', 'action'=>'user_posts')); ?></li>
				
				</ul>
			  </li>
			  <li><a href="">关于博客</a>
				<ul>
				<li><a href="">关于我们</a></li>
				<li><a href="">致谢</a></li>
				</ul>
			  </li>
				<?php
				if($this->Session->check('user'))
				{
					?> <li><a><?php echo '欢迎你！'.$this->Session->read('user');?></a>
					<ul><li><?php echo $this->Html->link('登出',array('controller' => 'Users','action' => 'logout'));?></li></ul>
							</li>
				<?php
				}
				else
				{
					?>
					<li><a href="">还未登录</a>
					<ul>
						<li><?php echo $this->Html->link('登录',array('controller' => 'Users', 'action'=>'login'));?> </li>
						<li><?php echo $this->Html->link('注册',array('controller'=>'Users','action'=>'add'));?></li>
					</ul>
					</li>
					<?php
				}
				?>
			</ul>
		</div>

		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
