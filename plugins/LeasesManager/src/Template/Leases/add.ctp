<?php
$compteur = 0;
?>
<script>
    var sum;
    var selected;

    /**
     * Initialisation des boutons de suppression
     * Un unbind est appelé avant pour éviter les appels multiples
     */
    function initDelButton() {
        $("a[data-role='removebutton']").unbind('click');

        $("a[data-role='removebutton']").bind('click', function () {
            selected = this;
            bootbox.confirm("<?= __('Etes-vous sûr de supprimer cette ligne?')?>", function (value) {
                    if (value) {
                        // ajout de la référence pour la suppression
                        $(selected).closest('tr').addClass('animated bounceOut');
                        $(selected).closest('tr').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', $(selected).closest('tr').remove());
                        calcul_total_ttc();
                    }
                }
            );
            return false;
        });
    }

    function calcul_montant_ht(compteur) {
        // récupération des informations tva, montant_ttc
        // récupération des informations montant_ht, tva
        $montant_ttc = parseFloat($("#loyer-loyerdetails-" + compteur + "-montant-ttc").val()).toFixed(2);
        $tva = parseFloat($("#loyer-loyerdetails-" + compteur + "-tva-id option:selected").text()).toFixed(2);
        $montant_ht = parseFloat($montant_ttc / (1 + ($tva / 100))).toFixed(2);
        $("#loyer-loyerdetails-" + compteur + "-montant-ht").val($montant_ht);
        $("#loyer-loyerdetails-" + compteur + "-montant-tva").val(($montant_ttc - $montant_ht).toFixed(2));
        calcul_total_ttc();
    }

    function calcul_montant_ttc(compteur) {
        // récupération des informations tva, montant_ttc
        // récupération des informations montant_ht, tva
        $montant_ht = parseFloat($("#loyer-loyerdetails-" + compteur + "-montant-ht").val()).toFixed(2);
        $tva = parseFloat($("#loyer-loyerdetails-" + compteur + "-tva-id option:selected").text());
        $montant_ttc = parseFloat($montant_ht * (1 + ($tva / 100))).toFixed(2);
        $("#loyer-loyerdetails-" + compteur + "-montant-ttc").val($montant_ttc);
        $("#loyer-loyerdetails-" + compteur + "-montant-tva").val(($montant_ttc - $montant_ht).toFixed(2));
        calcul_total_ttc();
    }

    function calcul_total_ttc() {
        sumttc = 0;
        sumtva = 0;
        sumht = 0;
        $('.totalht').each(function () {
            sumht += Number($(this).val());
        });
        $('.totaltva').each(function () {
            sumtva += Number($(this).val());
        });
        $('.totalttc').each(function () {
            sumttc += Number($(this).val());
        });
        $("#totalht").val(sumht.toFixed(2));
        $("#totaltva").val(sumtva.toFixed(2));
        $("#totalttc").val(sumttc.toFixed(2));
    }

    $(document).ready(function () {
        // initialisation des events sur le bouton suppression
        initDelButton();
        calcul_total_ttc();
        // évenement sur click du bouton d'ajout
        $("#addbutton").on('click', function () {
            compteur++;
            var $typeoperationselect = $("#typeoperationselect select").clone().attr("id", "loyer-loyerdetails-" + compteur + "-type_operation_id").attr("name", "loyer[loyerdetails][" + compteur + "][type_operation_id]").data('Template.AppPlugins.index', compteur);
            var $tvaselect = $("#tvaselect select").clone().attr("id", "loyer-loyerdetails-" + compteur + "-tva-id").attr("name", "loyer[loyerdetails][" + compteur + "][tva_id]").data('Template.AppPlugins.index', compteur).bind('change', function () {
                calcul_montant_ttc(compteur)
            });
            var $libelle = $("#inputlibelle input").clone().attr("id", "loyer-loyerdetails-" + compteur + "-libelle").attr("name", "loyer[loyerdetails][" + compteur + "][libelle]").data('Template.AppPlugins.index', compteur);
            var $inputmontantht = $("#inputmontantht input").clone().attr("required", "required").attr("id", "loyer-loyerdetails-" + compteur + "-montant-ht").attr("name", "loyer[loyerdetails][" + compteur + "][montant_ht]").data('Template.AppPlugins.index', compteur).bind('input', function () {
                calcul_montant_ttc(compteur);
            });
            var $inputmontanttva = $("#inputmontanttva input").clone().attr("required", "required").attr("id", "loyer-loyerdetails-" + compteur + "-montant-tva").attr("name", "loyer[loyerdetails][" + compteur + "][montant_tva]").data('Template.AppPlugins.index', compteur);
            var $inputmontantttc = $("#inputmontantttc input").clone().attr("required", "required").attr("id", "loyer-loyerdetails-" + compteur + "-montant-ttc").attr("name", "loyer[loyerdetails][" + compteur + "][montant_ttc]").data('Template.AppPlugins.index', compteur).bind('input', function () {
                calcul_montant_ht(compteur)
            });
            var $btndel = $("#btndel a").clone();
            $("#tabledetailsoperations").find('tbody')
                .append($('<tr>')
                        /*.append($('<td>').append(compteur))*/
                        .append($('<td>').append($typeoperationselect))
                        .append($('<td>').append($libelle))
                        .append($('<td>').append($inputmontantht))
                        .append($('<td>').append($tvaselect))
                        .append($('<td>').append($inputmontanttva))
                        .append($('<td>').append($inputmontantttc))
                        .append($('<td>').append($btndel))
                        .addClass('animated bounceInDown')
                );
            initDelButton();
            $("input[type=number]").numeric({decimal: ",", decimalPlaces: 2});
            return false;
        })
    });
</script>
<?= $this->Form->create($bail, ['horizontal' => TRUE]) ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= __('Edition d\'un bail') ?></div>
    <div class="panel-body">
        <?= $this->Form->input('id') ?>
        <?= $this->Form->input('designation', ['class' => 'input-sm',
                                               'label' => __('Désignation :')]) ?>
        <?= $this->Form->input('actif', ['class' => 'input-xs',
                                         'label' => __('Bail actif')]) ?>
        <?= $this->Form->input('societe_id', ['class' => 'input-sm',
                                              'label' => __('Societé :')]) ?>
        <?= $this->Form->input('bien_id', ['class' => 'input-sm',
                                           'label' => __('Bien rattaché :')]) ?>
        <?= $this->Form->input('tier_id', ['class' => 'input-sm',
                                           'label' => __('Tiers souscripteur :')]) ?>
        <?= $this->Form->input('type_periodicite_id', ['options' => $type_periodicites,
                                                       'class'   => 'input-sm',
                                                       'label'   => __('Périodicitié du loyer :')]) ?>
        <?= $this->Form->input('date_debut', ['data-role' => 'datepicker',
                                              'type'      => 'text',
                                              'class'     => 'input-sm',
                                              'label'     => __('Date du début de bail :')]) ?>
        <?= $this->Form->input('date_fin', ['data-role' => 'datepicker',
                                            'type'      => 'text',
                                            'class'     => 'input-sm',
                                            'label'     => __('Date de fin de bail :')]) ?>
        <?= $this->Form->input('valeur_indice', ['class' => 'input-sm',
                                                 'label' => __('Valeur de l\'indice :')]) ?>
        <?= $this->Form->input('commentaire', ['class' => 'input-sm',
                                               'label' => __('Commentaire sur le bail :')]) ?>

        <!-- Création d'un loyer type -->
        <?= $this->Form->input('loyer.id', ['type' => 'hidden']) ?>
        <!-- Fin création d'un loyer type -->
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><?= __('Création du loyer type') ?></div>
    <div class="panel-body">
        <table class="table table-striped" id="tabledetailsoperations">
            <thead>
            <tr>
                <th><?= __('Type') ?></th>
                <th><?= __('Libellé') ?></th>
                <th><?= __('Montant HT (€)') ?></th>
                <th><?= __('TVA (%)') ?></th>
                <th><?= __('Montant TVA (€)') ?></th>
                <th><?= __('Total TTC (€)') ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($bail->loyer->loyerdetails)): ; ?>
                <?php foreach ($bail->loyer->loyerdetails as $loyerdetail) : ?>
                    <tr>
                        <td>
                            <?= $this->Form->input('loyer.loyerdetails.' . $compteur . '.id',
                                ['value' => $loyerdetail->id,
                                 'class' => 'input-sm',]); ?>
                            <?= $this->Form->input('loyer.loyerdetails.' . $compteur . '.type_operation_id',
                                ['value'     => $loyerdetail->type_operation_id,
                                 'label'     => FALSE,
                                 'class'     => 'input-sm',
                                 'templates' => ['formGroup'      => '{{input}}',
                                                 'inputContainer' => '{{content}}',
                                                 'select'         => '<select class="form-control input-sm" {{attrs}} name={{name}}>{{content}}<select>'],
                                 'options'   => $type_operations]); ?>
                        </td>
                        <td>
                            <?= $this->Form->input('loyer.loyerdetails.' . $compteur . '.libelle',
                                ['default'   => $loyerdetail->libelle,
                                 'label'     => FALSE,
                                 'class'     => 'input-sm',
                                 'templates' => ['formGroup'      => '{{input}}',
                                                 'inputContainer' => '{{content}}',
                                                 'input'          => '<input class="form-control input-sm" type="{{type}}" name="{{name}}" {{attrs}}>',

                                 ],]); ?>
                        </td>
                        <td>
                            <?= $this->Form->input('loyer.loyerdetails.' . $compteur . '.montant_ht',
                                ['value'     => $loyerdetail->montant_ht,
                                 'label'     => FALSE,
                                 'class'     => 'input-sm',
                                 'oninput'   => 'calcul_montant_ttc(' . $compteur . ')',
                                 'templates' => ['formGroup'      => '{{input}}',
                                                 'inputContainer' => '{{content}}',
                                                 'input'          => '<input class="form-control input-sm totalht" type="{{type}}" name="{{name}}" {{attrs}}>',],]); ?>
                        </td>
                        <td>
                            <?= $this->Form->input('loyer.loyerdetails.' . $compteur . '.tva_id',
                                ['value'     => $loyerdetail->tva_id,
                                 'onchange'  => 'calcul_montant_ttc(' . $compteur . ')',
                                 'class'     => 'input-sm',
                                 'templates' => ['formGroup'      => '{{input}}',
                                                 'inputContainer' => '{{content}}',
                                                 'select'         => '<select class="form-control input-sm" {{attrs}} name={{name}}>{{content}}<select>'],
                                 'label'     => FALSE,
                                 'options'   => $tvas]); ?>
                        </td>
                        <td>
                            <?= $this->Form->input('loyer.loyerdetails.' . $compteur . '.montant_tva',
                                ['value'     => $loyerdetail->montant_tva,
                                 'label'     => FALSE,
                                 'class'     => 'input-sm',
                                 'templates' => ['formGroup'      => '{{input}}',
                                                 'inputContainer' => '{{content}}',
                                                 'input'          => '<input class="form-control input-sm totaltva" type="{{type}}" name="{{name}}" {{attrs}}>',],]); ?>
                        </td>
                        <td>
                            <?= $this->Form->input('loyer.loyerdetails.' . $compteur . '.montant_ttc',
                                ['value'     => $loyerdetail->montant_ttc,
                                 'label'     => FALSE,
                                 'class'     => 'input-sm',
                                 'oninput'   => 'calcul_montant_ht(' . $compteur . ')',
                                 'type'      => 'number',
                                 'step'      => 'any',
                                 'templates' => ['formGroup'      => '{{input}}',
                                                 'inputContainer' => '{{content}}',
                                                 'input'          => '<input class="form-control input-sm totalttc" type="{{type}}" name="{{name}}" {{attrs}}>',],]); ?>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm" data-role="removebutton" aria-label="Left Align"
                               data-toggle="tooltip"
                               data-placement="top" title="<?= __('Supprimer l\opération') ?>" href="#">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
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
                            <?= $this->Html->link('<span class="fa fa-plus"></span>&nbsp;' . __(' Ajouter une ligne'),
                                '#', ['id'     => 'addbutton',
                                      'escape' => FALSE,
                                      'class'  => 'btn btn-primary btn-sm']); ?>
                        </div>
                    </div>
                </td>
                <td></td>
                <td>
                    <input class="form-control input-sm" type="number" name="loyer[total_ht]" readonly id="totalht"
                           value="<?= isset($bail->loyer->total_ht) ? $bail->loyer->total_ht : "" ?>"/>
                </td>
                <td></td>
                <td>
                    <input class="form-control input-sm" type="number" name="loyer[total_tva]" readonly id="totaltva"
                           value="<?= isset($bail->loyer->total_tva) ? $bail->loyer->total_tva : "" ?>"/>
                </td>
                <td>
                    <input class="form-control input-sm" type="number" name="loyer[total_ttc]" readonly id="totalttc"
                           value="<?= isset($bail->loyer->total_ttc) ? $bail->loyer->total_ttc : "" ?>"/>
                </td>
                <td></td>
            </tr>
            </tfoot>

        </table>
    </div>
    <div class="panel-footer">
        <div class="text-right">
            <?= $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' . __('Enregistrer'),
                ['class'  => 'btn btn-primary btn-xs',
                 'escape' => FALSE]); ?>
            <?= $this->Form->end(); ?>
            <?= $this->Form->postLink('<i class="fa fa-trash"></i>&nbsp;' . __('Supprimer ce bail'),
                ['action' => 'delete',
                 $bail->id], ['class'   => 'btn btn-danger btn-xs',
                              'escape'  => FALSE,
                              'confirm' => __('Êtes-vous sûr de vouloir supprimer ce bail ? cette suppression est irréversible !')]) ?>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><?= __('Documents associés au bail') ?></div>
    <div class="panel-body">
        <?= $bail->has('id') ? $this->Element('Documenttiers/fiche',
            ['tier' => $bail->client]) : __('Enregistrer le bail pour ajouter des documents') ?>
    </div>
</div>

<!-- Templates pour l'ajout d'une nouvelle opération -->
<div id="typeoperationselect" style="display:none">
    <?= $this->Form->select('type_operation_id', $type_operations, ['empty' => FALSE,
                                                                    'label' => FALSE,
                                                                    'class' => 'input-sm']); ?>
</div>

<div id="tvaselect" style="display:none">
    <?= $this->Form->select('tva_id', $tvas, ['empty' => FALSE,
                                              'label' => FALSE,
                                              'class' => 'input-sm']); ?>
</div>
<div id="inputmontantht" style="display: none">
    <input class="form-control input-sm totalht" type="number" step="any">
</div>
<div id="inputlibelle" style="display: none">
    <input class="form-control input-sm detail_operation-libelle" type="texte">
</div>
<div id="inputmontanttva" style="display: none">
    <input class="form-control input-sm totaltva" type="number" step="any">
</div>
<div id="inputmontantttc" style="display: none">
    <input class="form-control input-sm totalttc" type="number" step="any">
</div>
<div id="btndel" style="display: none">
    <a class="btn btn-danger btn-sm" data-role="removebutton" aria-label="Left Align" data-toggle="tooltip"
       data-placement="top" title="<?= __('Supprimer l\'opération') ?>" href="#">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
    </a>
</div>
<!-- Fin des templates -->
<script>
    var compteur = <?= $compteur?>;
</script>
