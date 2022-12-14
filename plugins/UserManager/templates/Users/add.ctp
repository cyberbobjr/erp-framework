<?php
    /**
     * @var \App\View\AppView $this
     */
    $this->assign('title', $userToEdit->has('id') ? __('Edition d\'un utilisateur') : __('Ajout d\'un utilisateur'));
    $this->extend('/Common/panel');
    $this->start('panel-content');
    echo $this->Form->create($userToEdit);
?>
<fieldset>
    <?php
        echo $this->Form->input('username', ['label' => __('Login utilisateur :'),]);
        echo $this->Form->input('lastname', ['label' => __('Nom :'),]);
        echo $this->Form->input('firstname', ['label' => __('Prénom :'),]);
        echo $this->Form->input('civ', ['label'   => __('Civilité :'),
                                        'options' => ['Mr'    => 'Mr',
                                                      'Mme'   => 'Mme',
                                                      'Melle' => 'Melle']]);
        echo $this->Form->input('password', ['label' => __('Mot de passe :'),]);
        echo $this->Form->input('password_confirm', ['type'  => 'password',
                                                     'label' => __('Confirmer le mot de passe :'),]);
        echo $this->Form->input('groupes._ids', ['class' => 'js-basic-single',
                                                 'label' => __('Selectionnez un ou plusieurs groupes d\'appartenance :'),]);
        echo $this->Form->input('email', ['error' => ['class' => 'has-error'],
                                          'label' => __('Adresse courriel :'),]);
        echo $this->Form->input('phonenumber', ['error' => ['class' => 'has-error'],
                                                'label' => __('Téléphone :'),]);
    ?>
</fieldset>
<?php $this->end() ?>
<?php $this->start('footer'); ?>
<?= $this->Form->button('<i class="fa fa-check"></i> ' . __('Enregistrer'), ['class' => ['btn',
                                                                                         'btn-primary',],]); ?>
<?= $this->Form->end(); ?>
<?php $this->end() ?>
