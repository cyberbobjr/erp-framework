<?php
/**
 * @var \App\View\AppView $this
 */
?>
<style>
    .form-login {
        margin: 100px auto 0;
    }
</style>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="modal-title"><?= __('1ere connexion') ?></h3>
            </div>
            <div class="panel-body">
                <?= $this->Flash->render(); ?>
                <?= $this->Flash->render('auth'); ?>
                <strong><?= __('C\'est votre première connexion, vous devez saisir votre nouveau mot de passe pour pouvoir accéder au site.') ?></strong>
                <br/>

                <div class="alert alert-danger" role="alert">
                    <?= __('Le mot de passe doit être compris entre 8 et 20 caractères.') ?>
                </div>
                <?= $this->Form->create($userToEdit, ['align' => 'horizontal']);
                ?>
                <fieldset>
                    <legend>Sécurité</legend>
                    <?php
                    echo $this->Form->input('password', ['label' => __('Nouveau mot de passe :'),
                                                         'required']);
                    echo $this->Form->input('password_confirm', ['type'  => 'password',
                                                                 'label' => __('Confirmez votre nouveau mot de passe :'),
                                                                 'required']); ?>
                </fieldset>
                <?php
                echo $this->Form->submit(__('Enregistrer'), ['class' => 'btn btn-primary']);
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
