<div class="form-panel">
    <h4><i class="fa fa-angle-right"></i><?= __('Edition d\'un type de paiement') ?></h4>
    <?= $this->Form->create($typepaiement, ['horizontal' => TRUE]) ?>
    <?= $this->Form->input('libelle', ['label' => __('Libellé :')]) ?>
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
