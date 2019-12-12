<?php
    if ($this->request->params['action'] == 'edit') {
        $disabled = TRUE;
    } else $disabled = FALSE;
?>
<?= $this->Form->create($tier, ['horizontal' => TRUE]) ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Edition d\'un tiers') ?></h3>
    </div>
    <div class="panel-body">
        <?= $this->Form->input('id'); ?>

        <?= $this->Form->input('type_tier_id', ['class'    => 'input-sm',
                                                'label'    => __('Type de tiers :'),
                                                'options'  => $typetiers,
                                                'disabled' => $disabled,
                                                'required' => 'required']) ?>
        <?= $this->Form->input('lastname', ['class' => 'input-sm',
                                            'label' => __('Nom :')]) ?>
        <?= $this->Form->input('firstname', ['class' => 'input-sm',
                                             'label' => __('Prénom :')]) ?>
        <?= $this->Form->input('company_name', ['class' => 'input-sm',
                                                'label' => __('Raison sociale :')]) ?>
        <?= $this->Form->input('var', ['class' => 'input-xs',
                                       'label' => __('Soumis à TVA ?')]) ?>
        <?= $this->Form->input('address1', ['class' => 'input-sm',
                                            'label' => __('Adresse :')]) ?>
        <?= $this->Form->input('address2', ['class' => 'input-sm',
                                            'label' => __('Adresse (suite) :')]) ?>
        <?= $this->Form->input('zipcode', ['class' => 'input-sm',
                                           'label' => __('Code postal :')]) ?>
        <?= $this->Form->input('city', ['class' => 'input-sm',
                                        'label' => __('Ville :')]) ?>
        <?= $this->Form->input('phonenumber', ['class' => 'input-sm',
                                               'label' => __('Téléphone Fixe :')]) ?>
        <?= $this->Form->input('mobilenumber', ['class' => 'input-sm',
                                                'label' => __('Téléphone Mobile :')]) ?>
        <?= $this->Form->input('officenumber', ['class' => 'input-sm',
                                                'label' => __('Téléphone Société :')]) ?>
        <?= $this->Form->input('comments', ['class' => 'input-sm',
                                            'label' => __('Commentaires :')]) ?>
        <?= $this->Form->input('var_intra', ['class' => 'input-sm',
                                             'label' => __('TVA Intracommunautaire :')]) ?>
        <?= $this->Form->input('email', ['class' => 'input-sm',
                                         'label' => __('Courriel :')]) ?>
    </div>
    <div class="panel-footer">
        <div class="text-right">
            <?= $this->Form->submit('<i class="fa fa-floppy-o"></i>&nbsp;' . __('Enregistrer'), ['class' => 'btn btn-primary btn-xs']); ?>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>
