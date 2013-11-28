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
		echo $this->Html->css('myCss');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
?>
</head>
<body>
		<h1>NDSC BLOG</h1>
		<div class="box">
			<h2>Hello world</h2>
 			<ul id="ldd_menu" class="ldd_menu">

				<li><span>主页</span>
					<div class="ldd_submenu">
						<ul>
							<li><a><?php echo $this->Html->link('主页', array('controller'=>'Posts', 'action'=>'index')); ?></a></li>
						</ul>
					</div>
				</li>

				<li><span>个人信息</span>
					<div class="ldd_submenu">
						<ul>
							<li><a><?php echo $this->Html->link('个人信息管理',array('controller'=>'Users', 'action'=>'view')); ?></a></li>
							<li><a><?php echo $this->Html->link('我的博客',array('controller'=>'Posts', 'action'=>'user_posts')); ?></a></li>
						</ul>
					</div>
			  </li>

			  <li><span>关于博客</span>
				<div class="ldd_submenu">
					<ul>
					<li><?php echo $this->Html->link('关于我们', array('controller'=>'Posts', 'action'=>'aboutUs')); ?></li>
						<li><a>致谢</a></li>
					</ul>
				</div>
			  </li>

				<?php
				if($this->Session->check('user'))
				{
					?> <li><span><?php echo '欢迎你！'.$this->Session->read('user');?></span>
						<div class="ldd_submenu">
							<ul>
								<li><a><?php echo $this->Html->link('登出',array('controller' => 'Users','action' => 'logout'));?></a></li>
							</ul>
						</div>
					   </li>
				<?php
				}
				else
				{
					?>
					<li><span>还未登录</span>
						<div class="ldd_submenu">
							<ul>
								<li><a><?php echo $this->Html->link('登录',array('controller' => 'Users', 'action'=>'login'));?></a></li>
								<li><a><?php echo $this->Html->link('注册',array('controller'=>'Users','action'=>'add'));?></a></li>
							</ul>
						</div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>

	<div>
	<span class="reference">
		<a href="http://tympanus.net/codrops/2010/07/14/ui-elements-search-box/">© Codrops - back to post</a>
	</span>
	</div>
		<!-- The JavaScript -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
				/**
				 * the menu
				 */
				var $menu = $('#ldd_menu');
				
				/**
				 * for each list element,
				 * we show the submenu when hovering and
				 * expand the span element (title) to 510px
				 */
				$menu.children('li').each(function(){
					var $this = $(this);
					var $span = $this.children('span');
					$span.data('width',$span.width());
					
					$this.bind('mouseenter',function(){
						$menu.find('.ldd_submenu').stop(true,true).hide();
						$span.stop().animate({'width':'510px'},300,function(){
							$this.find('.ldd_submenu').slideDown(300);
						});
					}).bind('mouseleave',function(){
						$this.find('.ldd_submenu').stop(true,true).hide();
						$span.stop().animate({'width':$span.data('width')+'px'},300);
					});
				});
            });
        </script>	
		
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<!--<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('color.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div> -->
	</div>
	<!-- <?php echo $this->element('sql_dump'); ?> -->
</body>
</html>
