<div class="users form">
    <div class="page-header">
        <h2><?php echo __('Créer un utilisateur'); ?></h2>
    </div>
    <?php 
        echo $this->Form->create(
                'User',
                array(
                    'class' => 'horizontal-form',
                    'role' => 'form',
                    'type' => 'post',
                    'inputDefaults' => array(
                        'class'=>'form-control',
                        'div' => array(
                            'class' => 'form-group'
                        )
                    )
                )
        );
    ?>
	<fieldset>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('active');
		echo $this->Form->input('type');
	?>
	</fieldset>
    <?php 
        echo $this->Form->submit(__('Enregistrer'),array('type' => 'submit','class' => 'btn btn-primary'));
        echo $this->Form->end();
    ?>
</div>

<div class="row">
    <div class="col-md-5 pull-right well">
        <h2><?php echo __('Actions'); ?> : </h3>
        <?php echo $this->Html->link(__('Liste des Utilisateurs'), array('action' => 'index'),array('class' => 'btn btn-default pull-right')); ?>
    </div>
</div>