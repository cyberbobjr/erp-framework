<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php use Cake\Routing\Router;

    $this->assign('title', __('Gestion des biens')); ?>
<?php $controller = 'biens'; ?>

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
                return res.biens;
            },
            columns: [
                {
                    field: 'designation',
                    title: 'Designation du bien',
                    width: '15%',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {
                    field: 'adresse1',
                    title: 'Adresse',
                    width: 80,
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {
                    field: 'code_postal',
                    title: 'Code postal',
                    width: '10%',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {field: 'ville', title: 'Ville', width: 80, filterControl: "select"},
                {
                    field: 'societe:raison_sociale',
                    title: 'Société',
                    width: 80,
                    filterControl: "select"
                },
                {field: 'bail_actif:designation', title: 'Bail en cours', width: 80, filterControl: "select"},
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
