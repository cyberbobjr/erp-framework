<?php
    /**
     * @var \App\View\AppView $this
     * @var \UserManager\Model\Entity\Groupe $groupe
     */
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($groupe->label) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td style="vertical-align: middle;"><?= __('Libelle') ?></td>
            <td style="vertical-align: middle;"><?= h($groupe->label) ?></td>
            <td>
                <div style="display:block;width:32px;height: 32px;background-color: <?= $groupe->couleur ?>"></div>
            </td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Rights') ?></h3>
    </div>
    <?php if (!empty($groupe->rights)): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Code') ?></th>
                <th><?= __('Libelle') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groupe->rights as $right): ?>
                <tr>
                    <td><?= h($right->id) ?></td>
                    <td><?= h($right->code) ?></td>
                    <td><?= h($right->label) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="panel-body">no related Rights</p>
    <?php endif; ?>
</div>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Utilisateurs') ?></h3>
    </div>
    <?php if (!empty($groupe->users)): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Nom complet') ?></th>
                <th><?= __('Courriel') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groupe->users as $users): ?>
                <tr>
                    <td><?= h($users->nomcomplet) ?></td>
                    <td><?= $users->has('courriel') ? $this->Text->autoLinkEmails($users->courriel) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Users',
                                                                            'action'     => 'view',
                                                                            $users->id], ['title'  => __('View'),
                                                                                          'escape' => FALSE,
                                                                                          'class'  => 'btn btn-default']) ?>
                        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'Users',
                                                                               'action'     => 'edit',
                                                                               $users->id], ['title'  => __('Edit'),
                                                                                             'escape' => FALSE,
                                                                                             'class'  => 'btn btn-default']) ?>
                        <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'Users',
                                                                                  'action'     => 'delete',
                                                                                  $users->id],
                            ['confirm' => __('Are you sure you want to delete # {0}?',
                                $users->id),
                             'escape'  => FALSE,
                             'title'   => __('Delete'),
                             'class'   => 'btn btn-default']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="panel-body">no related Users</p>
    <?php endif; ?>
</div>
