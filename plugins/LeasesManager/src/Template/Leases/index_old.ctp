<?php $this->assign('title', __('Gestion des baux')); ?>
<?php $controller = "bails"; ?>
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
                    {field: 'designation', title: 'Designation du bail', width: '15%'},
                    {field: 'raison_sociale', title: 'Société', width: 80},
                    {field: 'bien', title: 'Désignation du bien', width: '10%'},
                    {field: 'periodicite', title: 'Périodicité', width: 80},
                    {field: 'tier', title: 'Client', width: 80},
                    {
                        field: 'montant_ttc',
                        title: 'Montant total TTC',
                        width: 80,
                        formatter: currencyFormater,
                        align: 'center'
                    },
                    {field: 'valeur_indice', title: 'Valeur de l\'indice', width: 80, align: 'center'},
                    {field: 'actif', title: 'Bail actif', width: 80, formatter: boolFormater, align: 'center'},
                    {field: 'date_debut', title: 'Date de début', width: 80, formatter: dateFormater, align: 'center'},
                    {field: 'date_fin', title: 'Date de fin', width: 80, formatter: dateFormater, align: 'center'},
                ]],
                loadFilter: function (data) {
                    $.each(data.rows, function (index, value) {
                        if (value.societe) {
                            data.rows[index].raison_sociale = value.societe.raison_sociale;
                        }
                        if (value.tier) {
                            data.rows[index].tier = value.tier.nom_complet;
                        }
                        if (value.bien) {
                            data.rows[index].bien = value.bien.designation;
                        }
                        if (value.type_periodicite) {
                            data.rows[index].periodicite = value.type_periodicite.libelle;
                        }
                        if (value.loyer) {
                            data.rows[index].montant_ttc = value.loyer.total_ttc;
                        }
                    });
                    output = {rows: data.rows, total: data.total};
                    return output;
                },
            });

        });
    </script>
    <table id="dt">

    </table>
<?= $this->element('paginator/pager',['controller'=>'bails'])?>