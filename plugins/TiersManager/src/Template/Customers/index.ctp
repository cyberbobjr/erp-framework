<?php $this->assign('title', __('Gestion des clients')); ?>
<?php

    use Cake\Routing\Router;
    use TiersManager\Model\Entity\Customer;

    $request = Router::getRequest(TRUE);

    $customer = new Customer();
    $fields = $customer->visibleProperties();
?>

<script>
    function open(id) {
        window.location.href = getUrlView(id);
    }

    function getUrlView($value) {
        return "<?= Router::url([
            'controller' => $request->getParam('controller'),
            'plugin'     => $request->getParam('plugin'),
            'action'     => 'view'
        ])?>/" + $value;
    }

    function getUrlEdit($value) {
        return "<?= Router::url([
            'controller' => $request->getParam('controller'),
            'plugin'     => $request->getParam('plugin'),
            'action'     => 'edit'
        ])?>/" + $value;
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
            var bootstraptable = $('#table');

            bootstraptable.on('click-row.bs.table', function (row, $element, field) {
                open($element.id);
            });

            bootstraptable.bootstrapTable({
                iconSize: "xs",
                filterShowClear: true,
                url: "<?= Router::url([
                    'controller' => $request->getParam('controller'),
                    'plugin'     => $request->getParam('plugin'),
                    'action'     => 'index'
                ])?>",
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
                    return res['customers'];
                },
                columns:
                <?= json_encode($fields)?>
            });
        });
</script>
<table id="table"></table>
