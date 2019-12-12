<?php
    /**
     * @var \App\View\AppView $this
     * @var \OperationsManager\Model\Entity\Operation $operation
     */
    namespace OperationsManager\Template\Operations;

    /**
     * @property \OperationsManager\Model\Entity\Operation $operation
     */

    use App\AppConstants;
    use OperationsManager\Model\Entity\Operation;
    use OperationsManager\Model\Entity\TypeOp;
    use OperationsManager\Model\Entity\TypeOperationDetail;


    $compteur = 1;
    $title = __('Création d\'une quittance');
    $buttons = [];
    /** @var TypeOp[] $type_ops */
    /** @var TypeOperationDetail[] $typeoperations */
    /** @var Operation $operation */
    if ($operation->can_be_open) {
        $buttons[] = $this->Utility->postLinkBoostrap(__('Réouvrir'), ['controller' => 'operations',
                                                                       'action'     => 'reOpen',
                                                                       $operation->id],
            ['confirm' => __('Etes-vous sur de vouloir réouvrir cette opération ?'),
             'class'   => 'btn btn-primary btn-xs',
             'type'    => 'button',]);
    }
    if ($operation->can_be_draft) {
        $buttons[] = $this->Utility->postLinkBoostrap(__('Repasser en brouillon'), ['controller' => 'operations',
                                                                                    'action'     => 'reDraft',
                                                                                    $operation->id],
            ['confirm' => __('Etes-vous sur de vouloir repasser cette opération en brouillon ? le solde restant ne sera plus intégré dans les créances en cours.'),
             'class'   => 'btn btn-primary btn-xs',
             'type'    => 'button',]);
    }
    if ($operation->can_be_paid) {
        $buttons[] = $this->Form->button(__('Reglements'), ['onclick' => 'reglement()',
                                                            'class'   => 'btn btn-primary btn-xs',
                                                            'type'    => 'button',]);
        $buttons[] = $this->Utility->postLinkBoostrap(__('Classer "Abandonnée"'), ['controller' => 'operations',
                                                                                   'action'     => 'cancel',
                                                                                   $operation->id],
            ['confirm' => __('Êtes-vous sûr de vouloir annuler cette opération ? le solde restant ne sera plus intégré dans les créances en cours.'),
             'class'   => 'btn btn-danger btn-xs']);
    }

    if ($operation->can_be_deleted) {
        $buttons[] = $this->Utility->postLinkBoostrap(__('Supprimer'), ['controller' => 'operations',
                                                                        'action'     => 'delete',
                                                                        $operation->id],
            ['title'       => __('Supprimer définitivement l\'opération'),
             'data-toggle' => 'tooltip',
             'confirm'     => __('Etes-vous sur de vouloir supprimer cette opération ?'),
             'class'       => 'btn btn-danger btn-xs',
             'type'        => 'button',]);
    }
    if ($operation->is_draft) {
        $buttons[] = $this->Utility->postLinkBoostrap(__('Valider'), ['controller' => 'operations',
                                                                      'action'     => 'validate',
                                                                      $operation->id],
            ['title'       => __('Valider l\'opération et la transformer en créance'),
             'data-toggle' => 'tooltip',
             'confirm'     => __('Etes-vous sur de vouloir valider cette opération ? une fois validée cette opération sera transformée en créance.'),
             'class'       => 'btn btn-success btn-xs']);

        $buttons[] = $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' . __('Enregistrer'),
            ['class'       => 'btn btn-primary btn-xs',
             'value'       => 'save',
             'title'       => __('Enregistrer l\'opération sans la valider'),
             'data-toggle' => 'tooltip',
             'type'        => 'submit',]);
    }
?>
<script>
    var sum;

    /**
     * Initialisation des boutons de suppression
     * Un unbind est appelé avant pour éviter les appels multiples
     */
    function initDelButton() {
        $("a[data-role='removebutton']")
            .unbind('click');

        $("a[data-role='removebutton']")
            .bind('click', function () {
                selected = this;
                bootbox.confirm("<?= __('Etes-vous sûr ?')?>", function (value) {
                        if (value) {
                            // ajout de la référence pour la suppression
                            $(selected)
                                .closest('tr')
                                .addClass('animated bounceOut');
                            $(selected)
                                .closest('tr')
                                .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', $(selected)
                                    .closest('tr')
                                    .remove());
                            calcul_total_ttc();
                        } else {
                            alert('Suppression annulée');
                        }
                    }
                );
                return false;
            });
    }

    function calcul_montant_ht(compteur) {
        // récupération des informations tva, montant_ttc
        // récupération des informations montant_ht, tva
        const $montant_ttc = parseFloat($("#operationdetails-" + compteur + "-montant-ttc")
            .val())
            .toFixed(2);
        const $tva = parseFloat($("#operationdetails-" + compteur + "-tva-id option:selected")
            .text())
            .toFixed(2);
        const $montant_ht = parseFloat($montant_ttc / (1 + ($tva / 100)))
            .toFixed(2);
        $("#operationdetails-" + compteur + "-montant-ht")
            .val($montant_ht);
        $("#operationdetails-" + compteur + "-montant-tva")
            .val(($montant_ttc - $montant_ht).toFixed(2));
        calcul_total_ttc();
    }

    function calcul_montant_ttc(compteur) {
        // récupération des informations tva, montant_ttc
        // récupération des informations montant_ht, tva
        const $montant_ht = parseFloat($("#operationdetails-" + compteur + "-montant-ht")
            .val())
            .toFixed(2);
        const $tva = parseFloat($("#operationdetails-" + compteur + "-tva-id option:selected")
            .text());
        const $montant_ttc = parseFloat($montant_ht * (1 + ($tva / 100)))
            .toFixed(2);
        $("#operationdetails-" + compteur + "-montant-ttc")
            .val($montant_ttc);
        $("#operationdetails-" + compteur + "-montant-tva")
            .val(($montant_ttc - $montant_ht).toFixed(2));
        calcul_total_ttc();
    }

    function calcul_total_ttc() {
        let sumttc = 0;
        let sumtva = 0;
        let sumht = 0;
        $('.totalht')
            .each(function () {
                sumht += Number($(this)
                    .val());
            });
        $('.totaltva')
            .each(function () {
                sumtva += Number($(this)
                    .val());
            });
        $('.totalttc')
            .each(function () {
                sumttc += Number($(this)
                    .val());
            });
        $("#totalht")
            .val(sumht.toFixed(2));
        $("#totaltva")
            .val(sumtva.toFixed(2));
        $("#totalttc")
            .val(sumttc.toFixed(2));
    }

    function refresh() {
        bootbox.confirm("Etes-vous sur de vouloir recréer les documents ?", function (value) {
            if (value) {
                $.ajax({
                    url: "<?=  $this->Url->build(['controller' => 'operations',
                                                  'action'     => 'regenerer',
                                                  $operation->id])?>",
                    type: 'post',
                    dataType: 'html',
                    success: function (html) {
                        window.location.href = "<?= $this->Url->build(['controller' => 'operations',
                                                                       'action'     => 'add',
                                                                       $operation->id])?>";
                    }
                });
            }
        });
        return false;
    }

    function reglement() {
        window.location.href = "<?= $this->Url->build(['controller' => 'reglements',
                                                       'action'     => 'add',
                                                       $operation->tier_id])?>";
    }

    function changeop() {
        let op_id = $("#type-op-id")
            .val();
        if (op_id === 1) {
            $("div[data-role=baildiv]")
                .slideDown();
            $("div[data-role=societediv]")
                .slideUp();
        } else {
            $("div[data-role=baildiv]")
                .slideUp();
            $("div[data-role=societediv]")
                .slideDown();
        }
    }

    $(document)
        .ready(function () {
            changeop();

            $("#refreshBtn")
                .bind('click', function () {
                    refresh();
                });

            initDatePicker();
            <?php if (!$operation->is_draft): // si l'événement est planifié nous désactivons l'ensemble des champs du formulaire?>
            $("fieldset")
                .prop('disabled', true);
            <?php endif;?>

            // initialisation des events sur le bouton suppression
            initDelButton();

            $("#tier-id")
                .bind('change', function () {
                    $.ajax({
                        'url': "<?= $this->Url->build(['controller' => 'bails',
                                                       'action'     => 'get_bails'])?>",
                        'data': {
                            'tier_id': $("#tier-id")
                                .val()
                        },
                        'dataType': 'json',
                        'method': 'post',
                        'success': function (json, textStatus, jqXHR) {
                            $("#bail-id")
                                .empty();
                            $("#bail-id")
                                .append('<option value="0"><?=__('Selectionnez un bail')?></option>');
                            $.each(json, function (index, value) { // pour chaque noeud JSON
                                // on ajoute l option dans la liste
                                // si l'option est selectionnée, alors nous l'activons
                                $("#bail-id")
                                    .append('<option value="' + index + '">' + value + '</option>');
                            });
                        }
                    });
                });

            // évenement sur click du bouton d'ajout
            $("#addbutton")
                .on('click', function () {
                    compteur++;
                    const $typeoperationselect = $("#typeoperationselect select")
                        .clone()
                        .attr("id", "operationdetails-" + compteur + "-type_operation_id")
                        .attr("name", "operationdetails[" + compteur + "][type_operation_id]")
                        .data('Template.AppPlugins.index', compteur);
                    const $tvaselect = $("#tvaselect select")
                        .clone()
                        .attr("id", "operationdetails-" + compteur + "-tva-id")
                        .attr("name", "operationdetails[" + compteur + "][tva_id]")
                        .data('Template.AppPlugins.index', compteur)
                        .bind('change', function () {
                            calcul_montant_ttc(compteur)
                        });
                    const $libelle = $("#inputlibelle input")
                        .clone()
                        .attr("id", "operationdetails-" + compteur + "-libelle")
                        .attr("name", "operationdetails[" + compteur + "][libelle]")
                        .data('Template.AppPlugins.index', compteur);
                    const $inputmontantht = $("#inputmontantht input")
                        .clone()
                        .attr("required", "required")
                        .attr("id", "operationdetails-" + compteur + "-montant-ht")
                        .attr("name", "operationdetails[" + compteur + "][montant_ht]")
                        .data('Template.AppPlugins.index', compteur)
                        .bind('input', function () {
                            calcul_montant_ttc(compteur);
                        });
                    const $inputmontanttva = $("#inputmontanttva input")
                        .clone()
                        .attr("required", "required")
                        .attr("id", "operationdetails-" + compteur + "-montant-tva")
                        .attr("name", "operationdetails[" + compteur + "][montant_tva]")
                        .data('Template.AppPlugins.index', compteur);
                    const $inputmontantttc = $("#inputmontantttc input")
                        .clone()
                        .attr("required", "required")
                        .attr("id", "operationdetails-" + compteur + "-montant-ttc")
                        .attr("name", "operationdetails[" + compteur + "][montant_ttc]")
                        .data('Template.AppPlugins.index', compteur)
                        .bind('input', function () {
                            calcul_montant_ht(compteur)
                        });
                    const $btndel = $("#btndel a")
                        .clone();
                    $("#tabledetailsoperations")
                        .find('tbody')
                        .append($('<tr>')
                            /*.append($('<td>').append(compteur))*/
                                .append($('<td>')
                                    .append($typeoperationselect))
                                .append($('<td>')
                                    .append($libelle))
                                .append($('<td>')
                                    .append($inputmontantht))
                                .append($('<td>')
                                    .append($tvaselect))
                                .append($('<td>')
                                    .append($inputmontanttva))
                                .append($('<td>')
                                    .append($inputmontantttc))
                                .append($('<td>')
                                    .append($btndel))
                                .addClass('animated bounceInDown')
                        );
                    initDelButton();
                    $("input[type=number]")
                        .numeric({decimal: ",", decimalPlaces: 2});
                    return false;
                })
        });
</script>
<?= $this->Flash->render(); ?>
<?= $this->Form->create($operation, ['horizontal' => TRUE]); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $title ?></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-7">
                <!-- Panneau d'information de la charge -->
                <fieldset>
                    <?= $this->Form->input('id'); ?>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"><?= __('Nom complet') ?></label>

                        <div class="col-xs-10">
                            <div class="form-control input-sm">
                                <?= $this->Html->link($operation->client->nom_complet, ['controller' => 'tiers',
                                                                                        'action'     => 'view',
                                                                                        $operation->tier_id,]) ?>
                            </div>
                        </div>
                    </div>
                    <div data-role="baildiv">
                        <?= $this->Form->input('bail_id', ['class' => 'input-sm',
                                                           'empty' => __('Selectionnez un bail (facultatif)'),]); ?>
                    </div>
                    <div data-role="societediv">
                        <?= $this->Form->input('societe_id', ['class' => 'input-sm',
                                                              'label' => __('Société'),]); ?>
                    </div>
                    <?= $this->Form->input('type_op_id', ['class'    => 'input-sm',
                                                          'options'  => $type_ops,
                                                          'label'    => __('Type d\'opération :'),
                                                          'onchange' => 'changeop()',]) ?>
                    <div class="form-group">
                        <div data-role="baildiv">
                            <label for="date-appel" class="col-xs-2 control-label">Période de l'appel</label>

                            <div class="col-xs-10">
                                <div class="input-group input-daterange" data-role="datepicker">
                                    <span class="input-group-addon"><?= __('Du') ?></span>
                                    <input type="text" name="debut_periode" class="form-control input-sm"
                                           data-role="datepicker" id="debut-periode"
                                           value="<?= $operation->debut_periode ?>">
                                    <span class="input-group-addon"><?= __('au') ?></span>
                                    <input type="text" name="fin_periode" class="form-control input-sm"
                                           data-role="datepicker" id="fin-periode"
                                           value="<?= $operation->fin_periode ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        echo $this->Form->input('date_echeance', ['data-role' => 'datepicker',
                                                                  'class'     => 'datepicker input-sm',
                                                                  'type'      => 'text',
                                                                  'label'     => __('Date d\'échéance'),]);
                        echo $this->Form->input('created', ['data-role' => 'datepicker',
                                                            'class'     => 'datepicker input-sm',
                                                            'type'      => 'text',
                                                            'label'     => __('Date d\'appel :'),]);
                        echo $this->Form->input('libelle', ['required' => 'required',
                                                            'class'    => 'input-sm',]);
                        echo $this->Form->input('commentairepublic', ['class' => 'input-sm',
                                                                      'label' => __('Commentaire public')]);
                        echo $this->Form->input('commentaireprive', ['class' => 'input-sm',
                                                                     'label' => __('Commentaire privé')]);
                    ?>
                </fieldset>
            </div>
            <div class="col-xs-5">
                <!-- Panneau d'information des réglements et documents-->
                <div class="panel panel-default">
                    <div class="panel-heading"><?= __('Réglements') ?></div>
                    <?= $this->cell('Reglements', ['operation_id' => $operation->id]); ?>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><?= __('Documents ') ?>
                        <?= $this->Html->link('<span class="fa fa-refresh"></span>', "#", ['id'     => 'refreshBtn',
                                                                                           'escape' => FALSE,
                                                                                           'style'  => 'color:green',
                                                                                           'title'  => __('Regénerer les fichiers'),]) ?>
                    </div>
                    <?= $this->cell('Documents', ['operation_id' => $operation->id]); ?>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><?= __('Informations') ?></div>
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>
                                <?php
                                    switch ($operation->state) {
                                        case AppConstants::STATE_DRAFT : // Brouillon
                                            echo '<span class="label label-primary">' . __('Brouillon') . '</span>';
                                            break;
                                        case AppConstants::STATE_OPEN : // Payé partiellement
                                            echo '<span class="label label-warning">' . __('En cours') . '</span>';
                                            break;
                                        case AppConstants::STATE_CLOSED : // Réglement commencé
                                            echo '<span class="label label-warning">' . __('Terminée') . '</span>';
                                            break;
                                        case AppConstants::STATE_CANCELLED : // Abandonné
                                            echo '<span class="label label-danger">' . __('Abandonnée') . '</span>';
                                            break;
                                        default:
                                            break;
                                    }
                                ?></h3>
                            <?php if ($operation->total_ttc > 0 && !$operation->isDraft) {
                                echo '<h3>';
                                if ($operation->solde > 0 && $operation->solde == $operation->total_ttc) {
                                    $label = __('Reste à payer : ') . number_format($operation->solde, 2, ",",
                                            " ") . "€";
                                    $class = 'danger';
                                } elseif ($operation->solde > 0) {
                                    $label = __('Reste à payer : ') . number_format($operation->solde, 2, ",",
                                            " ") . "€";
                                    $class = 'warning';
                                } else {
                                    $label = __('Payée');
                                    $class = 'success';
                                }
                                echo '<span class="label label-' . $class . '">' . $label . '</span>';
                                echo '</h3>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <fieldset>
                    <table class="table table-striped" id="tabledetailsoperations">
                        <thead>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Libellé (facultatif)') ?></th>
                            <th><?= __('Montant HT (€)') ?></th>
                            <th><?= __('TVA (%)') ?></th>
                            <th><?= __('Montant TVA (€)') ?></th>
                            <th><?= __('Total TTC (€)') ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($operation->operationdetails)): ; ?>
                            <?php foreach ($operation->operationdetails as $detail) : ?>
                                <tr>
                                    <td>
                                        <?= $this->Form->input('operationdetails.' . $compteur . '.id',
                                            ['value' => $detail->id,]); ?>
                                        <?= $this->Form->input('operationdetails.' . $compteur . '.typeoperation_id',
                                            ['value'     => $detail->type_operation_id,
                                             'label'     => FALSE,
                                             'class'     => 'input-sm',
                                             'options'   => $typeoperations,
                                             'templates' => ['inputContainer' => '{{content}}',
                                                             'formGroup'      => '{{input}}',
                                                             'select'         => '<select class="form-control input-sm" {{attrs}} name={{name}}>{{content}}<select>',],]); ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->input('operationdetails.' . $compteur . '.libelle',
                                            ['value'     => $detail->libelle,
                                             'label'     => FALSE,
                                             'class'     => 'input-sm',
                                             'templates' => ['inputContainer' => '{{content}}',
                                                             'formGroup'      => '{{input}}',],]); ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->input('operationdetails.' . $compteur . '.montant_ht',
                                            ['value'     => number_format($detail->montant_ht, 2,
                                                ".", ""),
                                             'label'     => FALSE,
                                             'oninput'   => 'calcul_montant_ttc(' . $compteur . ')',
                                             'class'     => 'input-sm totalht',
                                             'templates' => ['inputContainer' => '{{content}}',
                                                             'formGroup'      => '{{input}}',],]); ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->input('operationdetails.' . $compteur . '.tva_id',
                                            ['value'     => $detail->tva_id,
                                             'onchange'  => 'calcul_montant_ttc(' . $compteur . ')',
                                             'label'     => FALSE,
                                             'options'   => $tvas,
                                             'class'     => 'input-sm',
                                             'templates' => ['inputContainer' => '{{content}}',
                                                             'formGroup'      => '{{input}}',
                                                             'select'         => '<select class="form-control input-sm" {{attrs}} name={{name}}>{{content}}<select>',],]); ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->input('operationdetails.' . $compteur . '.montant_tva',
                                            ['value'     => number_format($detail->montant_tva, 2,
                                                ".", ""),
                                             'label'     => FALSE,
                                             'class'     => 'input-sm totaltva',
                                             'templates' => ['inputContainer' => '{{content}}',
                                                             'formGroup'      => '{{input}}',],]); ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->input('operationdetails.' . $compteur . '.montant_ttc',
                                            ['value'     => number_format($detail->montant_ttc, 2,
                                                ".", ""),
                                             'label'     => FALSE,
                                             'oninput'   => 'calcul_montant_ht(' . $compteur . ')',
                                             'type'      => 'number',
                                             'step'      => 'any',
                                             'class'     => 'input-sm totalttc',
                                             'templates' => ['inputContainer' => '{{content}}',
                                                             'formGroup'      => '{{input}}',],]); ?>
                                    </td>
                                    <td>
                                        <?php if ($operation->is_draft) : ?>
                                            <a class="btn btn-danger btn-sm" data-role="removebutton"
                                               aria-label="Left Align"
                                               data-toggle="tooltip"
                                               data-placement="top" title="<?= __('Supprimer l\'opération') ?>"
                                               href="#">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                $compteur++;
                            endforeach;
                        endif;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <?php if ($operation->is_draft) : ?>
                                            <?= $this->Html->link('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>' . __(' Ajouter une ligne'),
                                                '#', ['type'   => 'button',
                                                      'escape' => FALSE,
                                                      'id'     => 'addbutton',
                                                      'class'  => 'btn btn-primary btn-sm']); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <?= $this->Form->input('total_ht', ['name'      => 'total_ht',
                                                                    'step'      => 0.01,
                                                                    'readonly',
                                                                    'label'     => FALSE,
                                                                    'templates' => ['inputContainer' => '{{content}}',
                                                                                    'formGroup'      => '{{input}}'],
                                                                    'value'     => isset($operation->total_ht) ? number_format($operation->total_ht,
                                                                        2,
                                                                        ".",
                                                                        "") : "",
                                                                    'id'        => 'totalht']) ?>
                            </td>
                            <td></td>
                            <td>
                                <?= $this->Form->input('total_tva', ['name'      => 'total_tva',
                                                                     'step'      => 0.01,
                                                                     'readonly',
                                                                     'label'     => FALSE,
                                                                     'templates' => ['inputContainer' => '{{content}}',
                                                                                     'formGroup'      => '{{input}}'],
                                                                     'value'     => isset($operation->total_tva) ? number_format($operation->total_tva,
                                                                         2,
                                                                         ".",
                                                                         "") : "",
                                                                     'id'        => 'total_tva']) ?>
                            </td>
                            <td>
                                <?= $this->Form->input('total_ttc', ['name'      => 'total_ttc',
                                                                     'step'      => 0.01,
                                                                     'readonly',
                                                                     'label'     => FALSE,
                                                                     'templates' => ['inputContainer' => '{{content}}',
                                                                                     'formGroup'      => '{{input}}'],
                                                                     'value'     => isset($operation->total_ttc) ? number_format($operation->total_ttc,
                                                                         2,
                                                                         ".",
                                                                         "") : "",
                                                                     'id'        => 'total_ttc']) ?>
                            </td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="text-right">
            <?php foreach ($buttons as $button) : ?>
                <?= $button ?>
            <?php endforeach; ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<!-- Templates pour l'ajout d'une nouvelle opération -->
<div id="typeoperationselect" style="display:none">
    <?= $this->Form->select('type_operation_id', $typeoperations, ['empty' => FALSE,
                                                                   'class' => 'input-sm',
                                                                   'label' => FALSE,]); ?>
</div>

<div id="tvaselect" style="display:none">
    <?= $this->Form->select('tva_id', $tvas, ['empty' => FALSE,
                                              'class' => 'input-sm',
                                              'label' => FALSE,]); ?>
</div>
<div id="inputmontantht" style="display: none">
    <input class="form-control input-sm totalht" type="number" step="any" pattern="[0-9]+([\.,][0-9]+)?">
</div>
<div id="inputlibelle" style="display: none">
    <input class="form-control input-sm detail_operation-libelle" type="text">
</div>
<div id="inputmontanttva" style="display: none">
    <input class="form-control input-sm totaltva" type="number" step="any" pattern="[0-9]+([\.,][0-9]+)?">
</div>
<div id="inputmontantttc" style="display: none">
    <input class="form-control input-sm totalttc" type="number" step="any" pattern="[0-9]+([\.,][0-9]+)?">
</div>
<div id="btndel" style="display: none">
    <a class="btn btn-danger btn-sm" data-role="removebutton" aria-label="Left Align" data-toggle="tooltip"
       data-placement="top" title="<?= __('Supprimer l\opération') ?>" href="#">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
    </a>
</div>
<!-- Fin des templates -->
<script>
    var compteur = <?= $compteur?>;
</script>
