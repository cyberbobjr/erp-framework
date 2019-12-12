<?php
/**
 * Ecran d'ajout d'un réglement
 */
$compteur = 0;
?>
<script>
    function valider() {

    }

    function checkmax(el, $max) {
        $saisie = parseFloat($(el).val()).toFixed(2);
        if ($saisie > $max) {
            $(el).closest("div.form-group").addClass("has-error");
            $(el).closest("div.form-group").removeClass("has-success");
        } else {
            $(el).closest("div.form-group").removeClass("has-error");
            $(el).closest("div.form-group").addClass("has-success");
        }
    }

    $(function () {
        initDatePicker();
    })

</script>
<div class="panel panel-default">
    <div class="panel-heading"><?= __('Réglements') ?></div>
    <div class="panel-body">
        <?= $this->Form->create($reglement, ['horizontal' => TRUE]) ?>
        <?= $this->Form->input('id') ?>
        <?= $this->Form->input('date', ['data-role' => 'datepicker',
                                        'required'  => 'required',
                                        'class'     => 'input-sm',
                                        'type'      => 'text',
                                        'value'     => date('d/m/Y')]); ?>
        <?= $this->Form->input('banque_id', ['required' => 'required',
                                             'class'    => 'input-sm',
                                             'empty'    => __('Séléctionnez une banque')]); ?>
        <?= $this->Form->input('tier_id', ['disabled' => 'disabled',
                                           'options'  => $clients,
                                           'class'    => 'input-sm',
                                           'value'    => $tier_id]); ?>
        <?= $this->Form->input('type_paiement_id', ['empty'    => __('Séléctionnez un moyen de réglement'),
                                                    'options'  => $type_paiements,
                                                    'class'    => 'input-sm',
                                                    'required' => 'required']); ?>
        <?= $this->Form->input('numero', ['class' => 'input-sm',
                                          'empty' => __('Numéro de la pièce')]); ?>
        <?= $this->Form->input('commentaire', ['class' => 'input-sm']); ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <td><?= __('Référence') ?></td>
                <td><?= __('Date') ?></td>
                <td><?= __('Date d\'écheance') ?></td>
                <td><?= __('Libellé') ?></td>
                <td><?= __('Montant') ?></td>
                <td><?= __('Déjà payé') ?></td>
                <td><?= __('Reste à payer') ?></td>
                <td><?= __('Reglement') ?></td>
            </tr>
            </thead>
            <?php foreach ($operations as $operation): ?>
                <?= $this->Form->input('operations.' . $compteur . '.id', ['type'  => 'hidden',
                                                                           'class' => 'input-sm',
                                                                           'value' => $operation->id]); ?>
                <tr>
                    <td><?= $this->Html->link($operation->id, ['controller' => 'operations',
                                                               'action'     => 'add',
                                                               $operation->id], ['target' => '_blank']) ?></td>
                    <td><?= $operation->created ?></td>
                    <td><?= $operation->date_echeance ?></td>
                    <td><?= $operation->libelle ?></td>
                    <td><?= number_format($operation->total_ttc, 2, ",", " ") ?></td>
                    <td><?= number_format($operation->paye, 2, ",", " ") ?></td>
                    <td><?= number_format($operation->solde, 2, ",", " ") ?></td>
                    <td><?= $this->Form->input('operations.' . $compteur . '._joinData.montant', ['label'   => FALSE,
                                                                                                  'class'   => 'input-sm',
                                                                                                  'max'     => ($operation->total_ttc - $operation->paye),
                                                                                                  'oninput' => 'checkmax(this,' . ($operation->total_ttc - $operation->paye) . ')']); ?>
                    </td>
                </tr>
                <?php $compteur++;
            endforeach; ?>
        </table>
    </div>
    <div class="panel-footer">
        <div class="text-right"><?= $this->Form->button(__('Valider'), ['class' => 'btn btn-primary btn-xs']); ?></div>
    </div>
</div>