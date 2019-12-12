<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Edition d\'une société') ?></h3>
    </div>
    <div class="panel-body">
        <?= $this->Form->create($societes,  ['horizontal' => TRUE]) ?>
        <?= $this->Form->input('id'); ?>
        <?= $this->Form->input('raison_sociale', ['class' => 'input-sm',
                                                  'label' => __('Raison sociale :')]) ?>
        <?= $this->Form->input('adresse1', ['class' => 'input-sm',
                                            'label' => __('Adresse 1 :')]) ?>
        <?= $this->Form->input('adresse2', ['class' => 'input-sm',
                                            'label' => __('Adresse 2 :')]) ?>
        <?= $this->Form->input('code_postal', ['class' => 'input-sm',
                                               'label' => __('Code Postal :')]) ?>
        <?= $this->Form->input('ville', ['class' => 'input-sm',
                                         'label' => __('Ville :')]) ?>
        <?= $this->Form->input('tva', ['class' => 'input-xs',
                                       'label' => __('Soumise à la TVA'),
        ]) ?>
        <?= $this->Form->input('siret', ['class' => 'input-sm',
                                         'label' => __('Numéro de SIRET')]) ?>
        <?= $this->Form->input('tva_intra', ['class' => 'input-sm',
                                             'label' => __('TVA intracommunautaire')]) ?>
        <?= $this->Form->input('capital_variable', ['class' => 'input-sm',
                                                    'type'  => 'number',
                                                    'label' => __('Montant du capital variable')]) ?>
        <?= $this->Form->input('capital_plancher', [
            'class' => 'input-sm',
            'type'  => 'number',
            'label' => __('Montant du capital plancher')]) ?>
        <?= $this->Form->input('commentaires', ['class' => 'input-sm',
                                                'label' => __('Informations à inscrire sur le pied de page :')]) ?>
    </div>
    <div class="panel-footer">
        <div class="text-right">
            <?= $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' .__('Enregistrer'), ['class' => 'btn btn-primary btn-xs']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
