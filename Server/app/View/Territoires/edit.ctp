<div class="users form">
    <div class="page-header">
        <h2><?php echo __('Edition'); ?></h2>
    </div>
    <?php 
        echo $this->Form->create(
                'Territoire',
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
                echo $this->Form->input('name');
		echo $this->Form->input('coordinate');
		echo $this->Form->input('media');

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
        <?php echo $this->Html->link(__('Liste Territoire'), array('action' => 'index'),array('class' => 'btn btn-default')); ?>
        <?php echo $this->Form->postLink(
                        __('Supprimer Territoire'), 
                        array('action' => 'delete', $this->Form->value('Territoire.id')), 
                        array('class' => 'btn btn-danger pull-right'), 
                        __('Etes vous sûre de vouloir supprimer # %s?', $this->Form->value('Territoire.id'))
                ); 
        ?>
		
    </div>
</div>