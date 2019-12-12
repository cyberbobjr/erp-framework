<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php $this->assign('title', __('Gestion des operations')); ?>
<?php $controller = "operations"; ?>

<?php
    // détermination des variables de l'élément passées en paramètres
    // si aucune variable n'est déclarée, on utilise les paramètres par défaut
    // variable url, détermine l'url à executer sur rafraichissement
    if (!isset($url)) {
        $url = $this->Url->build([
            'controller' => $controller,
            'action'     => 'table',
        ]);
    }
?>
<script>
    $(function () {

        // déclaration du tableau
        // l'url est l'action "affiche_liens" du controller courant
        $('#dt').datagrid({
            url: '<?= $url ?>',
            idField: 'id',
            method: 'post',
            fitColumns: true,
            singleSelect: true,
            pagination: true,
            pageList: [10, 20, 30],
            footer: '#ft',
            columns: [[
                {
                    field: 'id', title: 'Numéro', width: '5%', formatter: function (value) {
                    return '<a href="<?=$this->Url->build(['controller'=>'operations','action'=>'add'])?>/' + value + '">' + value + '</a>';
                }
                },
                {field: 'date_echeance', title: 'Date d\'écheance', width: '10%', formatter: dateFormater},
                {field: 'libelle', title: 'Designation', width: '20%'},
                {field: 'bail', title: 'Bail en cours', width: '20%'},
                {
                    field: 'tiers', title: 'Client', width: '20%', formatter: function (value) {
                    if (value) {
                        return '<a href="<?=$this->Url->build(['controller'=>'tiers','action'=>'view'])?>/' + value.id + '">' + value.value + '</a>';
                    }
                }
                },
                {field: 'type_etat', title: 'Statut', width: '5%', formatter: etatFormater, align: 'center'},
                {field: 'total_ttc', title: 'Total TTC (€)', width: '5%', formatter: currencyFormater},
                {field: 'solde', title: 'Reste à payer TTC (€)', width: '5%', formatter: currencyFormater},
                {field: 'created', title: 'Date de création', width: '10%', formatter: dateFormater},
            ]],
            onBeforeLoad: function (param) {
                <?php if (!empty($type_etat_id)):?>
                param.type_etat_id = <?= $type_etat_id ?>;
                <?php endif;?>
                /*if (!row) {    // si aucune ligne présente
                 param.id = 0;    // on mets id à 0 pour réinitialiser la 1ere page
                 }*/
            },
            loadFilter: function (data) {
                $.each(data.rows, function (index, value) {
                    if (value.bail) {
                        data.rows[index].bail = value.bail.designation;
                    }
                    if (value.type_etat) {
                        data.rows[index].type_etat = value.type_etat;
                    }
                    if (value.tier) {
                        data.rows[index].tiers = {
                            value: value.tier.nom_complet,
                            id: value.tier.id
                        };
                    }
                });
                output = {rows: data.rows, total: data.total};
                return output;
            },
        })
        ;

    })
    ;
</script>
<table id="dt">

</table>
<?= $this->element('paginator/pager', ['controller' => $controller]) ?>
