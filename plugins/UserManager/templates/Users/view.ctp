<?php
    /**
     * Affichage du profil utilisateur,
     * Le profil affiche la photo / avatar de l'utilisateur, ainsi que ses informations de contact (nom / prénom / tel / email)
     *
     *
     * @var \App\View\AppView $this
     * @var \UserManager\Model\Entity\User $user
     */
    $this->assign('title', __('Fiche profil de {0}', $user->fullname));
    $this->assign('header', $this->Html->link('<i class="fa fa-pencil"></i>&nbsp;' . __('Editer'), ['controller' => 'Users',
                                                                                                    'action'     => 'edit',
                                                                                                    'plugin'     => 'UserManager',
                                                                                                    $user->id], ['class'  => 'btn btn-xs btn-success',
                                                                                                                 'escape' => FALSE]));

    $this->extend('/Common/panel');
    $this->start('panel-content');
?>
<div class="row">
    <div class="col-md-3 col-lg-3 " align="center">
        <?= $this->Html->image(empty($user->profile) ? 'UserManager.unknown-person.jpg' : '/profile/users/profile/' . $user->profile_path . '/' . $user->profile, ['alt'   => __('Image du profil utilisateur'),
                                                                                                                                                                   'style' => 'margin-left: auto;margin-right: auto;',
                                                                                                                                                                   'class' => 'img-circle img-responsive']); ?>
    </div>
    <div class=" col-md-9 col-lg-9 ">
        <table class="table table-user-information">
            <tbody>
            <tr>
                <td><?= __('Nom complet') ?></td>
                <td><?= $user->fullname ?></td>
            </tr>
            <tr>
                <td><?= __('Email') ?></td>
                <td><?= $user->has('email') ? $this->Text->autoLinkEmails($user->email) : '' ?></td>
            </tr>
            <tr>
                <td><?= __('Téléphone') ?></td>
                <td><?= $user->phonenumber ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?php
    $this->end();
?>

