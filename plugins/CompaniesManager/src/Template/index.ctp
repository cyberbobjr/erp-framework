<?php $this->assign('title', __('Gestion des sociétés')); ?>
<?php $controller = "societes"; ?>
<?php use Cake\Routing\Router; ?>

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
                return res.societes;
            },
            columns: [
                {field: 'raison_sociale', title: 'Raison sociale', width: '30%', filterControl: "select"},
                {
                    field: 'adresse1',
                    title: 'Adresse',
                    width: '40%',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {field: 'code_postal', title: 'Code postal', width: 80, filterControl: "select"},
                {field: 'ville', title: 'Ville', width: 150, filterControl: "select"},
                {
                    field: 'siret',
                    title: 'Numéro de SIRET',
                    width: 200,
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {
                    field: 'tva',
                    title: 'Soumise à la TVA',
                    align: 'center',
                    filterControl: "select",
                    width: 80,
                    formatter: function (value, row, index) {
                        return boolFormater(value);
                    }
                },
                {
                    field: "id",
                    formatter: buttonFormater,
                    width: "7%",
                }
            ]
        });
    });
</script>
<table id="table"></table>
