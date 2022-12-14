<?php
    /**
     * @var \App\View\AppView $this
     * @var \UserManager\Model\Entity\Right[] $rights
     */
?>
<?php $this->extend('/Common/panel'); ?>
<?php $this->assign('title', __('Gestion des droits')); ?>
<?php $this->assign('header', ''); ?>
<?php $this->start('panel-content'); ?>
<table cellpadding="0" cellspacing="0" class="table table-hovered table-striped table-condensed">
    <thead>
    <tr>
        <th><?= __('code'); ?></th>
        <th><?= __('libelle'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach ($rights as $droit): ?>
            <tr>
                <td><?= h($droit->code) ?></td>
                <td><?= h($droit->label) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->end() ?>
