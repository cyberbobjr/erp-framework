<?= $this->Html->script('jquery.easyui.min'); ?>
<?= $this->Html->script('easyui-lang-fr'); ?>

<?= $this->Html->script('jquery.json.min'); ?>
<?= $this->Html->script('datagrid-detailview'); ?>
<?= $this->Html->script('datagrid-filter'); ?>

<?= $this->Html->css('bootstrap/easyui'); ?>
<?= $this->Html->css('icon'); ?>
<?= $this->Html->css('color'); ?>

<script>
    $(document).ready(function () {
        $('#treeproduits').treegrid({
            queryParams: {
                societe_id: $('#societe').val()
            },
            idField: 'id',
            iconCls:'icon-ok',
            treeField: 'libelle',
            animate: true,
            collapsible: true,
            lines: true,
            fitColumns: true,
            showFooter: true,
            url: "<?= $this->Url->build(['controller'=>'Societes','action'=>'show_produits'])?>",
            columns: [[
                {field: 'id', title: 'N° Compte', width: 100, align: 'right'},
                {field: 'libelle', title: 'Libellé', width: 400},
                {field: 'montant', title: 'Montant (€)', width: 150, align: 'center'},
            ]]
        });
        $('#treecharges').treegrid({
            queryParams: {
                societe_id: $('#societe').val()
            },
            idField: 'id',
            iconCls:'icon-ok',
            treeField: 'libelle',
            animate: true,
            lines: true,
            collapsible: true,
            fitColumns: true,
            showFooter: true,
            url: "<?= $this->Url->build(['controller'=>'Societes','action'=>'show_charges'])?>",
            columns: [[
                {field: 'id', title: 'N° Compte', width: 100, align: 'right'},
                {field: 'libelle', title: 'Libellé', width: 400},
                {field: 'montant', title: 'Montant (€)', width: 150, align: 'center'},
            ]]
        });

        $('#societe').bind('change', function () {
            $('#treecharges').treegrid('load', {
                societe_id: $('#societe').val()
            });
            $('#treeproduits').treegrid('load', {
                societe_id: $('#societe').val()
            });
        })
    });
</script>
<div class="row">
    <div class="col-xs-12">
        <?php
        // Affichage de la liste des sociétés
        echo $this->Form->input('societe', ['options' => $societes,
                                            'label'   => __('Compte de résultat pour la société :')]);
        ?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-xs-6">
        <table id="treecharges" style="width:100%">

        </table>
    </div>
    <div class="col-xs-6">
        <table id="treeproduits" style="width:100%">

        </table>
    </div>
</div>
