<?php
    $this->Html->css('custom', null, array('inline' => false));
    $this->Html->script('custom', array('inline' => false, 'block' => 'scriptBottom'));
    
    /* Reading the configuration */
    $timePerBadge = Configure::read('TimePerBadge');
    
    /**
     * MySql equivalent to convert seconds to duration
     */
    function  sec_to_time($seconds){
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);
        return $hours.':'.date('i:s',$seconds);
    }
?>
<div class="userLogin history">
    <div class="row-fluid">  
        <div class="col-md-3">
            <div class="sidebar-form-fixed well">
                <?php echo $this->Form->create(
                                'User',
                                array(
                                    'class' => 'form',
                                    'type' => 'post',
                                    'inputDefaults' => array('label' => true),
                                    'url' => '/dates/history'
                                )
                      );
                ?>
                    <?= $this->Form->input(
                            'SearchUsername',
                            array(
                                'value'         => $this->Form->value('User.SearchUsername'),
                                'class'         =>'form-control',
                                'label'         =>'Nom d\'utilisateur',
                                'div'           => array('class' => 'form-group')
                            )
                        ); 
                    ?>
                <?php
                    echo $this->Form->submit(
                            __('Filtrer'),
                            array(
                                'type' => 'submit',
                                'name' => 'submit',
                                'class' => 'btn btn-primary pull-right col-xs-5'
                            )
                    );
                    echo $this->Html->link(__('Réinitialiser'),array('action' => 'history'),array('class' => 'btn btn-default pull-left col-xs-5'));
                ?>
                <?php
                    echo $this->Form->end();
                ?>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="page-header">
                <h2><?php echo __('Historique des connexions'); ?></h2>
            </div>
            <table cellpadding="0" cellspacing="0" class="table table-condensed table-hover">
                <thead>
                        <th><?php echo __('Heure de connexion'); ?></th>
                        <th><?php echo __('Identifiant Utilisateur'); ?></th>
                        <th><?php echo __('Nom d\'utilisateur') ?></th>
                        <?php if($this->Session->read('Auth.User.level') == 'admin'): ?><th class="actions"><?php echo __('Actions'); ?></th><?php endif; ?>
                </thead>
                <tbody>
                        <?php foreach ($dates as $date): ?>
                        <tr>
                                <td><?php echo h($date['Date']['time']); ?>&nbsp;</td>
                                <td><?php echo h($date['Date']['user_id']); ?>&nbsp;</td>
                                <td><?php echo h($date['User']['username']); ?>&nbsp;</td>
                                <?php if($this->Session->read('Auth.User.type') == 'admin'): ?>
                                <td class="actions">
                                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $date['Date']['id'])); ?>
                                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $date['Date']['id']), null, __('Are you sure you want to delete # %s?', $date['Date']['id'])); ?>
                                </td>
                                <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(empty($dates)): ?>
                <p>
                    <center>Aucun nom d'utilisateur correspondant</center>
                </p>
            <?php endif; ?>
        </div>
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
                <?php echo $this->Paginator->prev('< ' . __('précédent'),array('tag'=>'li','disabledTag'=>'a')); ?>
                <?php echo $this->Paginator->numbers(array('tag'=>'li','separator' => '','currentClass' => 'active','currentTag'=>'a')); ?>
                <?php echo $this->Paginator->next(__('suivant') . ' >',array('tag'=>'li','disabledTag'=>'a')); ?>
            </ul>
            <?php endif; ?>
        </div>
</div>
