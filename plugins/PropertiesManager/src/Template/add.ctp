<?php
/**
 * @var \App\View\AppView $this
 */
if ($this->request->params['action'] == 'edit') {
    $title    = __('Edition d\'un bien');
    $disabled = TRUE;
} else {
    $title    = __('Création d\'un bien');
    $disabled = FALSE;
}
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $title ?></div>
    <div class="panel-body">
        <?= $this->Form->create($bien,  ['horizontal' => TRUE]) ?>

        <?= $this->Form->input('id') ?>
        <?= $this->Form->input('designation', ['class' => 'input-sm',
                                               'label' => __('Désignation du bien :')]) ?>
        <?= $this->Form->input('adresse1', ['class' => 'input-sm',
                                            'label' => __('Adresse du bien :')]) ?>
        <?= $this->Form->input('adresse2', ['class' => 'input-sm',
                                            'label' => __('Adresse (suite) :')]) ?>
        <?= $this->Form->input('code_postal', ['class' => 'input-sm',
                                               'label' => __('Code postal :')]) ?>
        <?= $this->Form->input('ville', ['class' => 'input-sm',
                                         'label' => __('Ville :')]) ?>
        <?= $this->Form->input('numerolot', ['class' => 'input-sm',
                                             'label' => __('Numéro du lot :')]) ?>
        <?= $this->Form->input('etage', ['class' => 'input-sm',
                                         'label' => __('Etage :')]) ?>
        <?= $this->Form->input('porte', ['class' => 'input-sm',
                                         'label' => __('Lettre :')]) ?>
        <?= $this->Form->input('batiment', ['class' => 'input-sm',
                                            'label' => __('Batiment :')]) ?>
        <?= $this->Form->input('commentaires', ['class' => 'input-sm',
                                                'label' => __('Commentaires :')]) ?>
        <?= $this->Form->input('societe_id', [
            'empty'   => FALSE,
            'class'   => 'input-sm',
            'options' => $societes,
            'label'   => __('Société rattachée :')
        ]) ?>
    </div>
    <div class="panel-footer">
        <div class="text-right">
            <?= $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' .__('Enregistrer'), ['class' => 'btn btn-primary btn-xs']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
