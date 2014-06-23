<?php 
    $labelSucess = '<span class="label label-success">Oui </span>';
    $labelDanger = '<span class="label label-danger">Non</span>';
    $printedLabel = '';
?>
<div class="users index">
	<div class="page-header">
            <h2><?php echo __('Territoires'); ?></h2>
        </div>
	<table cellpadding="0" cellspacing="0" class="table table-condensed table-hover">
            <thead>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('coordinate'); ?></th>
			<th><?php echo $this->Paginator->sort('media'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
            </thead>
            <tbody>
                <?php foreach ($terittoires as $user): ?>
                <tr>
                        <td><?php echo h($user['Territoire']['id']); ?>&nbsp;</td>
                        <td><?php echo h($user['Territoire']['name']); ?>&nbsp;</td>
                        <td><?php echo h($user['Territoire']['coordinate']); ?>&nbsp;</td>
                        <td><?php echo h($user['Territoire']['media']); ?>&nbsp;</td>
                        <td class="actions">
                                <?php echo $this->Html->link(__('Editer'), array('action' => 'edit', $user['Territoire']['id'])); ?>
                                <?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $user['Territoire']['id']), null, __('Etes vous sûre de vouloir supprimer # %s?', $user['Territoire']['id'])); ?>
                        </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
	</table>
</div>

<div class="row">
    	<div class="col-md-7 pull-left">
            <div class="well">
            <?php
                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} sur {:pages}, {:current} résultats affichés sur un total de {:count}, débutant à {:start}, finissant à {:end}')
                ));
            ?>
            </div>
            <?php if($this->Paginator->numbers()): ?>
            <ul class="pagination">
                <?php echo $this->Paginator->prev('< ' . __('précédant'),array('tag'=>'li','disabledTag'=>'a')); ?>
                <?php echo $this->Paginator->numbers(array('tag'=>'li','separator' => '','currentClass' => 'active','currentTag'=>'a')); ?>
                <?php echo $this->Paginator->next(__('suivant') . ' >',array('tag'=>'li','disabledTag'=>'a')); ?>
            </ul>
            <?php endif; ?>
        </div>
	
        <div class="col-md-5 pull-right well">
            <h2><?php echo __('Actions'); ?> : </h3>
            <?php echo $this->Html->link(__('Nouveau Territoire'), array('action' => 'add'),array('class' => 'btn btn-primary pull-right')); ?>
        </div>
</div>
