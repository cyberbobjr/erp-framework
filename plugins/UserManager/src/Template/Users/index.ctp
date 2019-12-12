<?php
/**
 * @var \App\View\AppView $this
 * @var \UserManager\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?php $this->extend('/Common/panel'); ?>
<?php $this->assign('title', __('Gestion des utilisateurs')); ?>
<?php $this->assign('header',
    $this->Html->link('<span class="fa fa-plus"></span><span class="hidden-xs">&nbsp;' . __('Ajouter un utilisateur') . '</span>', ['controller' => 'users',
                                                                                                                                    'action'     => 'add'], ['escape' => FALSE,
                                                                                                                                                             'class'  => 'btn btn-xs btn-success'])); ?>
<?php $this->start('panel-content'); ?>
    <table class="table table-striped table-condensed">
        <thead>
        <tr>
            <th><?= __('Identifiant') ?></th>
            <th><?= __('Nom complet') ?></th>
            <th class="hidden-xs"><?= __('Courriel') ?></th>
            <th class="hidden-xs"><?= __('Role') ?></th>
            <th><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->username ?></td>
                <td><?= $user->nomcomplet ?></td>
                <td class="hidden-xs"><?= $user->courriel ?></td>
                <td class="hidden-xs">
                    <?php
                    $groupes = new \Cake\Collection\Collection($user->groupes);
                    $labels = $groupes->extract('label')
                                      ->toArray();
                    echo join(',', $labels);
                    ?>
                </td>
                <td>
                    <?= $this->Html->link('<span class="fa fa-eye"></span><span class="hidden-xs">&nbsp;' . __('Voir') . '</span>', ['action' => 'view',
                                                                                                                                     $user->id], ['class'       => 'btn btn-sm btn-success',
                                                                                                                                                  'data-toggle' => 'tooltip',
                                                                                                                                                  'title'       => __('Voir l\'utilisateur'),
                                                                                                                                                  'escape'      => FALSE]); ?>
                    <?= $this->Html->link('<span class="fa fa-pencil-square-o"></span><span class="hidden-xs">&nbsp;' . __('Editer') . '</span>', ['action' => 'edit',
                                                                                                                                                   $user->id], ['class'       => 'btn btn-sm btn-warning',
                                                                                                                                                                'data-toggle' => 'tooltip',
                                                                                                                                                                'title'       => __('Editer l\'utilisateur'),
                                                                                                                                                                'escape'      => FALSE]); ?>
                    <?= $this->Form->postLink('<span class="fa fa-trash-o"></span><span class="hidden-xs">&nbsp;' . __('Supprimer') . '</span>', ['action' => 'delete',
                                                                                                                                                  $user->id], ['class'       => 'btn btn-sm btn-danger',
                                                                                                                                                               'data-toggle' => 'tooltip',
                                                                                                                                                               'title'       => __('Supprimer l\'utilisateur'),
                                                                                                                                                               'confirm'     => __('Êtes-vous sûr de vouloir supprimer l\'utilisateur # {0}?', $user->id),
                                                                                                                                                               'escape'      => FALSE]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $this->end(); ?>