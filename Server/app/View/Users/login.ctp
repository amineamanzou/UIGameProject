<?php $this->Html->css('login', null, array('inline' => false)); ?>
<div id="form-signin">
    <?php echo $this->Session->flash('auth'); ?>
    <?php 
        echo $this->Form->create(
            'User',
             array(
                 'class'=>'well form-signin',
                 'inputDefaults'=>array('label'=>false,'error'=>false,'div'=>false)
                 )
        ); 
    ?>
        <h3 class="form-signin-heading"><?php echo __('Administration'); ?></h3>
        <hr>
        <?= $this->Form->input('username',array('class'=>'span3 form-control','placeholder'=>'Nom d\'utilisateur')); ?>
        <?= $this->Form->input('password',array('class'=>'span3 form-control','placeholder'=>'Mot de passe')); ?><br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
    </form>
</div>
