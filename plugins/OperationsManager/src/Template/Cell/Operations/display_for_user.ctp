<?php
    /**
     * @var \App\View\AppView $this
     * @var $tier_id
     */
?>
<?php $this->assign('title', __('Gestion des opérations')); ?>
<?php $controller = "operations"; ?>
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

    $()
        .ready(function () {
            var $table = $('#table-<?=$uuid?>');

            $table.on('click-row.bs.table', function (row, $element, field) {
                open($element.id);
            });

            $table.bootstrapTable({
                iconSize: "xs",
                pageSize: 5,
                filterShowClear: true,
                url: "<?= Router::url(['controller'                  => $controller,
                                       'action'                      => 'index',
                                       'include'                     => ['Leases'],
                                       'filter[Operations][tier_id]' => $tier_id])?>",
                sidePagination: "client",
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
                    return res.operations;
                },
                columns: [
                    {field: 'date_echeance', title: 'Date d\'échéance', width: '10%', formatter: dateFormater},
                    {field: 'libelle', title: 'Libellé'},
                    {field: 'bail:designation', title: 'Bail', width: '20%'},
                    {
                        field: 'total_ttc',
                        title: 'Montant €',
                        width: '10%',
                        formatter: currencyFormater
                    },
                    {field: 'solde', title: 'Reste à payer', width: '10%', formatter: currencyFormater},
                ]
            });
        });
</script>
<table id="table-<?= $uuid ?>"></table>
