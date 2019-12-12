<?php
    /**
     * @var \App\View\AppView $this
     * @var \OperationsManager\Model\Entity\Operation $operation
     * @var \OperationsManager\Model\Entity\TypeOp[] $type_ops
     */
?>
<?php $title = __('Selectionnez le type d\'opération'); ?>
<?php
    if (empty($operation->created)) {
        $operation->created = date('d/m/Y');
    }
?>

<?php $this->extend('/Common/panel'); ?>

<?php $this->start('title') ?>
<?= __('Création d\'une opération') ?>
<?php $this->end() ?>

<?= $this->Form->create($operation) ?>
<?= $this->Hooks->getHooks('beforeinputs') ?>

<?php if (empty($type_ops)): ?>
    <?= $this->Form->control('label', ['class'    => 'input-sm',
                                       'required' => 'required',
                                       'empty'    => __('Label')]) ?>
<?php endif; ?>
<?= $this->Form->control('tier_id', ['class'    => 'input-sm',
                                     'required' => 'required',
                                     'label'    => __('Client'),
                                     'empty'    => __('Selectionnez un client')]) ?>
<?= $this->Form->control('created', ['class'     => 'input-sm',
                                     'type'      => 'text',
                                     'data-role' => 'datepicker',
                                     'default'   => $operation->created,
                                     'label'     => __('Date de création')]) ?>
<?= $this->Form->control('due_date', ['data-role' => 'datepicker',
                                      'label'     => __('Date d\'échéance'),
                                      'class'     => 'input-sm',
                                      'type'      => 'text']) ?>
<?= $this->Form->control('type_op_id', ['class'    => 'input-sm',
                                        'label'    => __('Type de facturation'),
                                        'options'  => $type_ops,
                                        'required' => 'required']) ?>
<?= $this->Form->control('commentspublic', ['class' => 'input-sm',
                                            'label' => __('Commentaire public')]) ?>
<?= $this->Form->control('commentsprivate', ['class' => 'input-sm',
                                             'label' => __('Commentaire privé')]) ?>
<?= $this->Hooks->getHooks('afterinputs') ?>

<?php $this->start('actions') ?>
<?= $this->Form->button(__('Créer brouillon'), ['class' => 'btn btn-primary btn-xs']) ?>
<?= $this->Form->end() ?>
<?php $this->end() ?>
