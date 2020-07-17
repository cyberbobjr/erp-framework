<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$this->assign('title', __('Liste des utilisateurs'));
$this->extend('/Common/panel');
?>
<script>
    $(document).ready(function () {
        $('.confirmation').on('click', function () {
            return confirm('Etes-vous sûr ?');
        });
    });
</script>
<a type="button" class="btn btn-primary btn-sm" aria-label="Left Align" href="<?= $this->Url->build(['controller' => 'Users',
    'action' => 'add']) ?>">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><?= __(' Ajouter un utilisateur') ?>
</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th><?= __('Login') ?></th>
            <th><?= __('Role') ?></th>
            <th><?= __('Action') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user):; ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->username; ?></td>
                    <td><?= $user->role->texte; ?></td>
                    <td>
                        <a type="button" class="btn btn-primary btn-sm" aria-label="Left Align" href="<?=
                        $this->Url->build(['controller' => 'Users',
                            'action' => 'edit',
                            $user->id])
                        ?>">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </a>
                        <a type="button" class="btn btn-danger btn-sm confirmation" aria-label="Left Align" href="<?=
                        $this->Url->build(['controller' => 'Users',
                            'action' => 'delete',
                            $user->id])
                        ?>">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
    <?php endforeach; ?>
    </tbody>
</table>
