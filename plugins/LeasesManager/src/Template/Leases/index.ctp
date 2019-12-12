<?php

    use Cake\Routing\Router;

    $controller = 'Bails';
?>
<script>

    function open(id) {
        window.location.href = getUrlView(id);
    }

    function getUrlView($value) {
        return "<?= Router::url(['controller' => $controller,
                                 'action'     => 'view'])?>/" + $value;
    }

    function getUrlEdit($value) {
        return "<?= Router::url(['controller' => $controller,
                                 'action'     => 'add'])?>/" + $value;
    }

    function buttonFormater(value) {
        var $urlView = getUrlView(value);
        var $urlEdit = getUrlEdit(value);
        return `
            <a href="${$urlView}" class='btn btn-xs btn-primary'><i class="fa fa-eye"></i></a>
            <a href="${$urlEdit}" class='btn btn-xs btn-success'><i class="fa fa-pencil"></i></a>
         `;
    }

    $().ready(function () {
        var $table = $('#table');

        $table.on('click-row.bs.table', function (row, $element, field) {
            open($element.id);
        });

        $table.bootstrapTable({
            iconSize: "xs",
            filterShowClear: true,
            url: "<?= Router::url(['controller' => $controller,
                                   'action'     => 'index'])?>",
            sidePagination: "client",
            striped: true,
            flat: true,
            flatSeparator: ":",
            filterControl: true,
            idField: "id",
            uniqueId: "id",
            pagination: true,
            showColumns: true,
            locale: 'fr-FR',
            responseHandler: function (res) {
                return res.baux;
            },
            columns: [
                {
                    field: 'designation',
                    title: 'Designation du bail',
                    width: '15%',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {field: 'societe:raison_sociale', title: 'Société', width: 80, filterControl: "select"},
                {field: 'bien:designation', title: 'Désignation du bien', width: '10%', filterControl: "select"},
                {field: 'client:nom_complet', title: 'Client', width: 80, filterControl: "select"},
                {
                    field: 'loyer:total_ttc',
                    title: 'Montant total TTC',
                    width: 80,
                    formatter: currencyFormater,
                    align: 'center'
                },
                {field: 'valeur_indice', title: 'Valeur de l\'indice', width: 80, align: 'center'},
                {
                    field: 'actif',
                    title: 'Bail actif',
                    width: 80,
                    formatter: boolFormater,
                    align: 'center',
                    filterControl: "select"
                },
                {
                    field: 'date_debut',
                    title: 'Date de début',
                    width: 80,
                    formatter: dateFormater,
                    align: 'center',
                    filterControl: "datepicker",
                    filterDatepickerOptions: {
                        "autoclose": true,
                        "clearBtn": true,
                        "todayHighlight": true,
                        "language": "fr"
                    }
                },
                {
                    field: 'date_fin',
                    title: 'Date de fin',
                    width: 80,
                    formatter: dateFormater,
                    align: 'center',
                    filterControl: "datepicker",
                    filterDatepickerOptions: {
                        "autoclose": true,
                        "clearBtn": true,
                        "todayHighlight": true,
                        "language": "fr"
                    }
                },
                {
                    field: "id",
                    formatter: buttonFormater,
                    width: "7%",
                }
            ]
        });
    })
</script>
<table id="table"
       class="table table-striped">
    <tbody>
    </tbody>
</table>
