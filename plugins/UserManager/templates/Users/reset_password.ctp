<?php
/**
 * @var \App\View\AppView $this
 */
?>
<style>
    .center-block {
        float: none;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Réinitialisation du mot de passe') ?></h3>
    </div>
    <div class="panel-body">
        <div class="row mt">
            <div class="col-lg-12">
                <?= $this->Flash->render(); ?>
                <?= $this->Flash->render('auth'); ?>

                <?php
                echo $this->Form->create($userToEdit, ['align' => ['sm' => ['left'   => 6,
                                                                      'middle' => 6,
                                                                      'right'  => 12],
                                                             'md' => ['left'   => 4,
                                                                      'middle' => 4,
                                                                      'right'  => 4]]]);
                echo $this->Form->input('password', ['label' => __('Choisissez un mot de passe :'),
                                                     'required']);
                echo $this->Form->input('password_confirm', ['type'  => 'password',
                                                             'label' => __('Confirmer votre mot de passe :'),
                                                             'required']);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 center-block">
                <?php
                echo $this->Form->button('<i class="fa fa-check"></i> ' . __('Enregistrer'), ['class' => ['btn',
                                                                                                          'btn-primary']]);
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
