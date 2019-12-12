<?php use Cake\Routing\Router;

    $this->assign('title', __('Gestion des banques')); ?>
<?php $controller = 'banques'; ?>

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
                return res.banques;
            },
            columns: [
                {
                    field: 'nom',
                    title: 'Nom',
                    width: '10%',
                    filterControlPlaceholder: "",
                    filterControl: "select"
                },
                {
                    field: 'numero',
                    title: 'Numéro',
                    width: '10%',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {field: 'raison_sociale', title: 'Société', width: 40, filterControl: "select"},
                {
                    field: 'designation',
                    title: 'Numéro',
                    width: '10%',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {
                    field: 'adresse',
                    title: 'Adresse',
                    width: '20%',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {field: 'code_postal', title: 'Code postal', width: 40, filterControl: "select"},
                {field: 'ville', title: 'Ville', width: 80, filterControl: "select"},
                {
                    field: 'contact', title: 'Contact', width: 80, filterControlPlaceholder: "", filterControl: "input"
                },
                {
                    field: 'telephone',
                    title: 'Téléphone',
                    width: 80,
                    filterControlPlaceholder: "",
                    filterControl: "input"
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
