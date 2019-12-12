<?php
/**
 * @var \App\View\AppView $this
 * @var \UserManager\Model\Entity\Groupe[]|\Cake\Collection\CollectionInterface $groupes
 */
?>
<?php $this->extend('/Common/panel'); ?>
<?php $this->assign('title', __('Gestion des groupes')); ?>
<?php $this->assign('header',
    $this->Html->link('<i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;' . __('Ajouter un groupe') . '</span>', ['controller' => 'Groupes',
                                                                                                                         'action'     => 'add'], ['escape' => FALSE,
                                                                                                                                                  'class'  => 'btn btn-xs btn-success'])); ?>
<?php $this->start('panel-content'); ?>
    <table cellpadding="0" cellspacing="0" class="table table-striped bootstrap-table" id="groupetable"
           data-toolbar="#toolbar">
        <thead>
        <tr>
            <th><?= __('#'); ?></th>
            <th><?= __('Libellé'); ?></th>
            <th><?= __('Description'); ?></th>
            <th data-field="actions" class="actions"><?= __('Actions'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($groupes as $groupe): ?>
            <tr>
                <td><?= $this->Number->format($groupe->id) ?></td>
                <td><?= h($groupe->label) ?></td>
                <td><?= h($groupe->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="fa fa-eye"></span><span class="hidden-xs">&nbsp;' . __('Voir') . '</span>', ['action' => 'view',
                                                                                                                                     $groupe->id], ['class'       => 'btn btn-sm btn-success',
                                                                                                                                                    'data-toggle' => 'tooltip',
                                                                                                                                                    'title'       => __('Voir le groupe'),
                                                                                                                                                    'escape'      => FALSE]); ?>
                    <?= $this->Html->link('<span class="fa fa-pencil-square-o"></span><span class="hidden-xs">&nbsp;' . __('Editer') . '</span>', ['action' => 'edit',
                                                                                                                                                   $groupe->id], ['class'       => 'btn btn-sm btn-warning',
                                                                                                                                                                  'data-toggle' => 'tooltip',
                                                                                                                                                                  'title'       => __('Editer le groupe'),
                                                                                                                                                                  'escape'      => FALSE]); ?>
                    <?= ($groupe->label == 'ADMIN') ? '' : $this->Form->postLink('<span class="fa fa-trash-o"></span><span class="hidden-xs">&nbsp;' . __('Supprimer') . '</span>', ['action' => 'delete',
                                                                                                                                                                                      $groupe->id], ['class'       => 'btn btn-sm btn-danger',
                                                                                                                                                                                                     'data-toggle' => 'tooltip',
                                                                                                                                                                                                     'title'       => __('Supprimer le groupe'),
                                                                                                                                                                                                     'confirm'     => __('Êtes-vous sûr de vouloir supprimer le groupe # {0}?', $groupe->id),
                                                                                                                                                                                                     'escape'      => FALSE]) ?>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $this->end() ?>