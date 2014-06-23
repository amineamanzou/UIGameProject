<div class="dates form">
    <div class="page-header">
        <h2><?php echo __('Edit Date'); ?></h2>
    </div>
    <?php 
        echo $this->Form->create(
                'Date',
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
                echo $this->Form->input('id');
                echo $this->Form->input('time');
                echo $this->Form->input('user_id');
            ?>
	</fieldset>
    <?php 
        echo $this->Form->submit(__('Submit'),array('type' => 'submit','class' => 'btn btn-primary'));
        echo $this->Form->end();
    ?>
</div>

<div class="row">
    <div class="col-md-7 pull-right well">
        <h2><?php echo __('Dates'); ?> : </h3>
        <?php echo $this->Html->link(__('List Dates'), array('action' => 'index'),array('class' => 'btn btn-default')); ?>
        <?php echo $this->Form->postLink(
                        __('Delete Date'), 
                        array('action' => 'delete', $this->Form->value('Date.id')), 
                        array('class' => 'btn btn-danger pull-right'), 
                        __('Are you sure you want to delete # %s?', $this->Form->value('Date.id'))
                ); 
        ?>	
    </div>
</div>