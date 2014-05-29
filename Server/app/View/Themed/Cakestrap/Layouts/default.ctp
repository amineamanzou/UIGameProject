<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'TowerDefense : Admin');
?>
<?php echo $this->Html->docType('html5'); ?> 
<html>
    
	<head>
            <?php echo $this->Html->charset(); ?>
            <title>
                <?php echo $cakeDescription ?>:
                <?php echo $title_for_layout; ?>
            </title>
            <?php
                echo $this->Html->meta('icon', $this->Html->url('/favicon.png'));

                echo $this->fetch('meta');

                echo $this->Html->css('bootstrap');
                echo $this->Html->css('bootstrap-glyphicons');
                echo $this->Html->css('main');
                echo $this->Html->css('backendCustom');

                echo $this->fetch('css');

                echo $this->Html->script('libs/jquery-1.10.2.min');
                echo $this->Html->script('libs/bootstrap.min');

                echo $this->fetch('script');
            ?>
	</head>

	<body data-spy="scroll" data-target="#mynav" data-offset="90">
            <div class="container-fluid">
		<div id="main-container">
                    
			<div id="header" class="container" style="padding-bottom: 30px;">
                            <?php echo $this->element('menu/top_menu'); ?>
			</div><!-- /#header .container -->
			
                        <?php if($this->Session->read('Auth.User')): ?>
                            <?php echo $this->element('menu/side_menu'); ?>
                            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                                <div id="content" class="container">
                                    <?php echo $this->Session->flash(); ?>
                                    <?php echo $this->fetch('content'); ?>
                                </div><!-- /#content .container -->

                                <?php if($this->Session->read('Auth.User.level') == "admin"): ?>
                                    <div class="container">
                                        <div class="well well-sm">
                                            <small>
                                                <?php echo $this->element('sql_dump'); ?>
                                            </small>
                                        </div><!-- /.well well-sm -->
                                    </div><!-- /.container -->
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div id="content" class="container">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
                            </div><!-- /#content .container -->
                        <?php endif; ?>
                        
		</div><!-- /#main-container -->
                <?php echo $this->fetch('scriptBottom'); ?>
	</body>

</html>