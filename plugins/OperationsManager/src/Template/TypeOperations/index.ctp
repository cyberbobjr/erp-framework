<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php use Cake\Routing\Router;

    $this->assign('title', __('Gestion des types d\'opérations')); ?>
<?php $controller = "type_operations"; ?>

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
        var $urlEdit = getUrlEdit(value);
        return `
            <a href="${$urlEdit}" class='btn btn-xs btn-success'><i class="fa fa-pencil"></i></a>
         `;
    }

    $(function () {
        var $table = $('#dt');

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
            columns: [
                {
                    field: 'libelle',
                    title: 'Libellé',
                    filterControlPlaceholder: "",
                    filterControl: "input"
                },
                {
                    field: "id",
                    formatter: buttonFormater,
                    width: "2%",
                }
            ],
            responseHandler: function (res) {
                return res.type_operations;
            }
        });
    });
</script>
<table id="dt"></table>
