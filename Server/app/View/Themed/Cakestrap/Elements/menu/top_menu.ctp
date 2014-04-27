<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="navbar-header">
            <?php if($this->Session->read('Auth.User.level') == 'admin'): ?>
		<?php 
                    echo $this->Html->image("logo.png", array(
                        'alt' => "Nespresso Backend",
                        'url' => array('controller' => 'pages', 'action' => 'index'),
                        'class' => 'navbar-brand',
                        'style' => 'height: 50px;'
                    ));
                ?>
            <?php else: ?>
                <?php 
                    echo $this->Html->image("logo.png", array(
                        'alt' => "Nespresso Backend",
                        'url' => array('controller' => 'statistics', 'action' => 'dashboard'),
                        'class' => 'navbar-brand',
                        'style' => 'height: 50px;'
                    ));
                ?>
            <?php endif; ?>
	</div><!-- /.navbar-header -->
        <?php if($this->Session->read('Auth.User')): ?>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <?php if($this->Session->read('Auth.User.level') == 'admin'): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 1 <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                  <li <?= (strcasecmp($this->params['controller'],'users') == 0)?'class="active"':''; ?> >
                                      <?php echo $this->Html->link('Utilisateurs',array('controller' => 'users', 'action' => 'index')); ?>
                                  </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 2<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                  
                                </ul>
                              </li>
                        <?php endif; ?>
                        <li  <?= (strcasecmp($this->params['controller'],'dates') == 0)?'class="active"':''; ?> >
                            <?php echo $this->Html->link('Historique des connexions',array('controller' => 'dates', 'action' => 'loginHistory')); ?>
                        </li>
                    </ul><!-- /.nav navbar-nav -->
                    <ul class="nav navbar-nav navbar-right">
                        <li><?php echo $this->Html->link('Déconnexion',array('controller' => 'users', 'action' => 'logout')); ?></li>
                    </ul>
            </div><!-- /.navbar-collapse -->
        <?php endif; ?>
</nav><!-- /.navbar navbar-default -->