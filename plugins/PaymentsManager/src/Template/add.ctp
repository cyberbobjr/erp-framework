<?php
$compteur = 1;
$this->assign('title', __('Création d\'un paiement'));
?>
<script>
    function refresh_operation() {
        $tier_id = $("#tier-id").val();
        $societe_id = $("#societe-id").val();

        $.ajax({
            url: "<?= $this->Url->build(['controller' => 'Operations',
                                         'action'     => 'getoperations'])?>",
            data: {id: $tier_id, societe_id: $societe_id},
            type: "POST",
            dataType: 'json', // on veut un retour JSON
            success: function (json) {
                $("#operation-id").empty();
                $("#operation-id").append('<option><?= __('Selectionner une opération')?></option>');
                $.each(json, function (index, value) { // pour chaque noeud JSON
                    // on ajoute l option dans la liste
                    $("#operation-id").append('<option value="' + index + '">' + value + '</option>');
                });
            }
        });
    }

    $(document).ready(function () {
        $("#societe-id").bind("change", function (ev) {
            $societe_id = $("#societe-id").val();
            $.ajax({
                url: "<?= $this->Url->build(['controller' => 'Paiements',
                                             'action'     => 'getbanques'])?>",
                data: {id: $societe_id},
                type: "POST",
                dataType: 'json', // on veut un retour JSON
                success: function (json) {
                    $("#banque-id").empty();
                    $.each(json, function (index, value) { // pour chaque noeud JSON
                        // on ajoute l option dans la liste
                        $("#banque-id").append('<option value="' + index + '">' + value + '</option>');
                    });
                }
            });
            refresh_operation();
        });
        $("#tier-id").bind("change", function (ev) {
            refresh_operation();
        });
        $('input[name=date]').datepicker(
            {
                format: "yyyy/mm/dd",
                language: "fr",
                orientation: "top left",
                autoclose: true,
                todayHighlight: true
            }
        );
    });
</script>
<?php
echo $this->Form->create($paiements, ['horizontal' => TRUE]);
echo $this->Form->input('societe_id', ['required' => 'required',
                                       'options'  => $societes,
                                       'empty'    => __('-- Choisir une société --')]);
echo $this->Form->input('banque_id', ['options' => $banques]);
echo $this->Form->input('tier_id', ['options' => $tiers]);
echo $this->Form->input('type_paiement_id', ['options' => $typepaiements]);
echo $this->Form->input('operation_id');
echo $this->Form->input('date', ['class'   => 'datepicker',
                                 'type'    => 'text',
                                 'default' => date("Y/m/d")]);
echo $this->Form->input('libelle');
echo $this->Form->input('commentaires');
echo $this->Form->input('totalttc', ['type'     => 'number',
                                     'required' => 'required',
                                     'label'    => __('Montant (€)')]);
echo $this->Form->input('id');
?>
<div class="row">
    <div class="col-xs-2 col-xs-offset-5">
        <?php
        echo $this->Form->button('<i class="fa fa-floppy-o"></i>&nbsp;' . __('Enregistrer'), ['class' => ['btn', 'btn-default']]);
        echo $this->Form->end();
        ?>
    </div>
</div>
