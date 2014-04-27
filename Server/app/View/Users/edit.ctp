<div class="users form">
    <div class="page-header">
        <h2><?php echo __('Edition'); ?></h2>
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
                echo $this->Form->input('experience');
		echo $this->Form->input('money');
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
        <?php echo $this->Html->link(__('Liste Utilisateurs'), array('action' => 'index'),array('class' => 'btn btn-default')); ?>
        <?php echo $this->Form->postLink(
                        __('Supprimer Utilisateur'), 
                        array('action' => 'delete', $this->Form->value('User.id')), 
                        array('class' => 'btn btn-danger pull-right'), 
                        __('Etes vous sûre de vouloir supprimer # %s?', $this->Form->value('User.id'))
                ); 
        ?>
		
    </div>
</div>