<?php
/**
 * @var \App\View\AppView $this
 */

    use Cake\Routing\Router;

    $controller = 'Operations';
?>

<script>

    function open(id) {
        window.location.href = getAddUrl() + "/" + id;
    }

    function getAddUrl() {
        return "<?= Router::url(['controller' => $controller,
                                 'plugin'     => 'OperationsManager',
                                 'action'     => 'add'])?>";
    }

    function getIndexUrl() {
        return "<?= Router::url(['controller' => $controller,
                                 'plugin'     => 'OperationsManager',
                                 'action'     => 'index'])?>";
    }

    function buttonFormater(value) {
        const $urlView = getAddUrl();
        return `
            <a href="${$urlView}/${value}" class='btn btn-xs btn-success'><i class="fa fa-eye"></i></a>
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
            url: getIndexUrl(),
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
                return res.operations;
            },
            rowStyle: function (row, index) {
                const classRow = etatBTFormatter(row);
                return {
                    classes: classRow
                };
            }
        });
    })
</script>
<table id="table"
       class="table table-striped">
    <thead>
    <tr>
        <th class="text-center"
            data-field="id">#
        </th>
        <th data-sortable="true"
            class="text-center"
            data-width="5%"
            data-field="date_echeance"
            data-filter-control="datepicker"
            data-formatter="dateFormater"
            data-filter-datepicker-options='{"autoclose":true, "clearBtn": true, "todayHighlight": true, "language":"fr"}'>
            <?= __('Date d\'échéance') ?>
        </th>
        <th data-field="libelle"
            data-width="25%"
            data-filter-control-placeholder="Rechercher une désignation..."
            data-filter-control="input">
            <?= __('Désignation') ?>
        </th>
        <th data-field="bail:designation"
            data-width="25%"
            data-filter-control-placeholder="Rechercher un bail..."
            data-filter-control="input">
            <?= __('Bail en cours') ?>
        </th>
        <th data-sortable="true"
            data-field="client:nom_complet"
            data-filter-control="select">
            <?= __('Client') ?>
        </th>
        <th data-sortable="true"
            class="text-center"
            data-field="etat"
            data-filter-control="select">
            <?= __('Statut') ?>
        </th>
        <th class="text-center"
            data-field="total_ttc"
            data-formatter="currencyFormater"
            data-filter-control="input">
            <?= __('Total TTC') ?>
        </th>
        <th data-sortable="true"
            class="text-center"
            data-field="solde"
            data-formatter="currencyFormater"
            data-filter-control="input">
            <?= __('Reste à payer') ?>
        </th>
        <th data-field="id"
            data-formatter="buttonFormater">
        </th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>