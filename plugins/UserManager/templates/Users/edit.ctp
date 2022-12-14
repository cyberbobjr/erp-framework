<?php
    /**
     * @var \App\View\AppView $this
     * @var \UserManager\Model\Entity\User $userToEdit
     */
    $this->assign('title', $userToEdit->has('id') ? __('Edition d\'un utilisateur') : __('Ajout d\'un utilisateur'));
    $this->extend('/Common/panel');
    $this->start('panel-content');

    use UserManager\Utility\Droits as DroitsAlias; ?>
<?= $this->Form->create($userToEdit, ['type'  => 'file',
                                      'align' => ['sm' => ['left'   => 3,
                                                           'middle' => 9,
                                                           'right'  => 12],
                                                  'md' => ['left'   => 3,
                                                           'middle' => 8,
                                                           'right'  => 3]]]); ?>
<div class="row">
    <div class="col-sm-12 col-md-3 col-lg-3 text-center">
        <?php
            if (strpos($userToEdit->profile, 'https:') !== FALSE) {
                $profile = $userToEdit->profile;
            } elseif (empty($userToEdit->profile)) {
                $profile = 'UserManager.unknown-person.jpg';
                echo $this->Html->image($profile, ['alt'   => __('Image du profil utilisateur'),
                                                   'style' => 'margin-left: auto;margin-right: auto;',
                                                   'class' => 'img-circle img-responsive']);
            } elseif (strpos($userToEdit->profile, 'base64') > 0) {
                echo '<img src="' . $userToEdit->profile . '" class="img-circle img-responsive">';
            } elseif (strpos($userToEdit['profile'], 'https:') > 0) {
                echo '<img src="' . $userToEdit['profile'] . '" style="height: 45px;">';
            }
        ?>
        <?= __('Télécharger une image du profil, taille maximale : 300x300 pixels'); ?>
        <?= $this->Form->file('profile', ['accept' => 'image/*']) ?>
    </div>
    <div class="col-sm-12 col-md-9 col-lg-9">
        <fieldset>
            <legend><?= __('Gestion du mot de passe') ?></legend>
            <?php
                echo $this->Form->input('password', ['label'   => __('Mot de passe :'),
                                                     'value'   => '',
                                                     'default' => '']);
                echo $this->Form->input('password_confirm', ['type'  => 'password',
                                                             'label' => __('Confirmer le mot de passe :'),]);
            ?>
        </fieldset>
        <fieldset>
            <legend><?= __('Informations utilisateur') ?></legend>
            <?= $this->Form->input('id'); ?>
            <?php
                echo $this->Form->input('username', ['label' => __('Login utilisateur :'),]);
                echo $this->Form->input('civ', ['label'   => __('Civilité :'),
                                                'options' => ['Mr'    => 'Mr',
                                                              'Mme'   => 'Mme',
                                                              'Melle' => 'Melle']]);
                echo $this->Form->input('sex', ['label'   => __('Sexe :'),
                                                'options' => ['H' => 'Homme',
                                                              'F' => 'Femme']]);
                echo $this->Form->input('firsname', ['label' => __('Prénom :'),]);
                echo $this->Form->input('lastname', ['label' => __('Nom :'),]);
                echo $this->Form->input('address', ['label' => __('Adresse :'),]);
                echo $this->Form->input('address1', ['label' => __('Adresse (complément) :'),]);
                echo $this->Form->input('zipcode', ['label' => __('Code postal :'),]);
                echo $this->Form->input('city', ['label' => __('Ville :'),]);
                echo $this->Form->input('phonenumber', ['label' => __('Téléphone :'),]);
                echo $this->Form->input('email', ['error' => ['class' => 'has-error'],
                                                  'label' => __('Adresse email :'),]);
            ?>
        </fieldset>
        <?php if (DroitsAlias::aLeDroit('ADMIN')): ?>
            <fieldset>
                <?php echo $this->Form->input('groupes._ids', ['class' => 'js-basic-single',
                                                               'label' => __('Selectionnez un ou plusieurs groupes d\'appartenance :'),]); ?>
            </fieldset>
        <?php endif; ?>
    </div>
</div>
<?php $this->end() ?>
<?php $this->start('footer'); ?>
<?php
    echo $this->Form->button('<i class="fa fa-check"></i>&nbsp;' . __('Enregistrer'), ['class' => ['btn',
                                                                                                   'btn-primary']]);
    echo $this->Form->end();
?>
<?php $this->end() ?>
