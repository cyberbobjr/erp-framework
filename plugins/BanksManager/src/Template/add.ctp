<?php
if ($this->request->params['action'] == 'edit') {
    $title    = __('Edition d\'une banque');
    $disabled = TRUE;
} else {
    $title    = __('Création d\'une banque');
    $disabled = FALSE;
}
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $title ?></div>
    <div class="panel-body">
        <?= $this->Form->create($banque,  ['horizontal' => TRUE]) ?>
        <?= $this->Form->input('id') ?>
        <?= $this->Form->input('nom', ['class' => 'input-sm',
                                       'label' => __('Libellé de la banque :')]) ?>
        <?= $this->Form->input('numero', ['class' => 'input-sm',
                                          'label' => __('Numéro du compte :')]) ?>
        <?= $this->Form->input('societe_id', [
            'empty'   => FALSE,
            'options' => $societes,
            'class'   => 'input-sm',
            'label'   => __('Société rattachée :')
        ]) ?>
        <?= $this->Form->input('caisse', ['class' => 'input-xs',
                                          'label' => __('Compte de caisse ?')
        ]) ?>
        <?= $this->Form->input('designation', ['class' => 'input-sm',
                                               'label' => __('Désignation :')]) ?>
        <?= $this->Form->input('adresse', ['class' => 'input-sm',
                                           'label' => __('Adresse :')]) ?>
        <?= $this->Form->input('code_postal', ['class' => 'input-sm',
                                               'label' => __('Code postal :')]) ?>
        <?= $this->Form->input('ville', ['class' => 'input-sm',
                                         'label' => __('Ville :')]) ?>
        <?= $this->Form->input('contact', ['class' => 'input-sm',
                                           'label' => __('Contact :')]) ?>
        <?= $this->Form->input('telephone', ['class' => 'input-sm',
                                             'label' => __('Téléphone :')]) ?>
    </div>
    <div class="panel-footer">
        <div class="text-right">
            <?= $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' .__('Enregistrer'), ['class' => 'btn btn-primary btn-xs']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
