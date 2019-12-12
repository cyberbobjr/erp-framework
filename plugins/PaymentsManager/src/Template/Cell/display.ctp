<?php $this->assign('title', __('Gestion des réglements')); ?>
<?php $controller = "reglements"; ?>
<?php use Cake\Routing\Router;
    use Cake\Utility\Text;

?>
<?php
$uuid = Text::uuid();
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
        var $table = $('#table-<?=$uuid?>');

        $table.on('click-row.bs.table', function (row, $element, field) {
            open($element.id);
        });

        $table.bootstrapTable({
            iconSize: "xs",
            filterShowClear: true,
            url: "<?= Router::url(['controller'             => $controller,
                                   'action'                 => 'index',
                                   'include'                => ['Banques',
                                                                'TypePaiements'],
                                   'filter[Operations][id]' => $operation_id])?>",
            sidePagination: "client",
            pageSize: 5,
            striped: true,
            flat: true,
            flatSeparator: ":",
            filterControl: false,
            idField: "id",
            uniqueId: "id",
            pagination: true,
            showColumns: false,
            locale: 'fr-FR',
            responseHandler: function (res) {
                return res.reglements;
            },
            columns: [
                {field: 'date', title: 'Date', width: '10%', formatter: dateFormater},
                {field: 'numero', title: 'Numéro de pièce', width: '20%'},
                {
                    field: '_matchingData:OperationsReglements:montant',
                    title: 'Montant €',
                    width: '10%',
                    formatter: currencyFormater
                },
                {field: 'banque:designation', title: 'Banque', width: '40%'},
                {field: 'type_paiement:libelle', title: 'Type', width: '20%'}
            ]
        });
    });
</script>
<table id="table-<?= $uuid ?>"></table>
