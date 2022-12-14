<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($droit->libelle) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Code') ?></td>
            <td><?= h($droit->code) ?></td>
        </tr>
        <tr>
            <td><?= __('Libelle') ?></td>
            <td><?= h($droit->libelle) ?></td>
        </tr>
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($droit->id) ?></td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Groupes ayant ce droit') ?></h3>
    </div>
    <?php if (!empty($droit->groupes)): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Libelle') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($droit->groupes as $groupes): ?>
                <tr>
                    <td><?= h($groupes->id) ?></td>
                    <td><?= h($groupes->label) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('', ['controller' => 'Groupes', 'action' => 'view', $groupes->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                        <?= $this->Html->link('', ['controller' => 'Groupes', 'action' => 'edit', $groupes->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                        <?= $this->Form->postLink('', ['controller' => 'Groupes', 'action' => 'delete', $groupes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupes->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="panel-body"><?=__('Pas de groupes concernés par ce droit')?></p>
    <?php endif; ?>
</div>
