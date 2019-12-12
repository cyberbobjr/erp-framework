<div class="form-panel">
    <h4><i class="fa fa-angle-right"></i><?= __('Edition d\'un type de tiers') ?></h4>
    <?= $this->Form->create($typetiers, ['horizontal' => TRUE]) ?>
    <?= $this->Form->input('libelle', ['label' => __('Libellé :')]) ?>
    <?= $this->Form->input('sens', ['label'   => __('Sens :'),
                                    'options' => $sens]) ?>
    <?= $this->Form->input('plan_id', ['label'   => __('Compte parent :'),
                                       'options' => $list]) ?>
    <div class="row">
        <div class="col-xs-2 center-block">
            <?php
            echo $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' . __('Enregistrer'), ['class' => ['btn',
                                                                                                              'btn-theme']]);
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
