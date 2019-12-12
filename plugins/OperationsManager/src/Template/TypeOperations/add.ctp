<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Edition d\'un type d\'opération') ?></h3>
    </div>
    <div class="panel-body">
        <?= $this->Form->create($type_operation,  ['horizontal' => TRUE]) ?>
        <?= $this->Form->input('id'); ?>
        <?= $this->Form->input('libelle', ['class' => 'input-sm',
                                           'label' => __('Libellé :')]) ?>
    </div>
    <div class="panel-footer">
        <div class="text-right">
            <?= $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' .__('Enregistrer'), ['class' => 'btn btn-primary btn-xs']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
