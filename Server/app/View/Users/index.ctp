<?php 
    $labelSucess = '<span class="label label-success">Oui </span>';
    $labelDanger = '<span class="label label-danger">Non</span>';
    $printedLabel = '';
?>
<div class="users index">
	<div class="page-header">
            <h2><?php echo __('Utilisateurs'); ?></h2>
        </div>
	<table cellpadding="0" cellspacing="0" class="table table-condensed table-hover">
            <thead>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('money'); ?></th>
			<th><?php echo $this->Paginator->sort('experience'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('type','Access'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                        <td><?php echo h($user['User']['id']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['username']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['money']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['experience']); ?>&nbsp;</td>
                        <td>
                            <label class="checkbox-inline">
                                <input type="checkbox" data-id="<?= $user['User']['id'] ?>" value="" <?= ($user['User']['active']==1)?'checked':''; ?>>
                            </label>&nbsp;
                        </td>
                        <td><?php echo h($user['User']['type']); ?>&nbsp;</td> 
                        <td class="actions">
                                <?php echo $this->Html->link(__('Editer'), array('action' => 'edit', $user['User']['id'])); ?>
                                <?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $user['User']['id']), null, __('Etes vous sûre de vouloir supprimer # %s?', $user['User']['id'])); ?>
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
            <?php echo $this->Html->link(__('Nouvel Utilisateur'), array('action' => 'add'),array('class' => 'btn btn-primary pull-right')); ?>
        </div>
</div>

<script type="text/javascript">
    jQuery('input[type = checkbox]').bind('click',function() {

        var Id = jQuery(this).attr('data-id'); 
        
        var request = $.ajax({
            type: "GET",
            url: "<?= Router::url(array("controller" => "users", "action" => "userActivation"),true); ?>/"+Id,
            dataType: "html"
        });
        request.done(function( msg ) {
            console.log("Request done");
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log("Request failed: " + textStatus );
        });
                   
    });
</script>