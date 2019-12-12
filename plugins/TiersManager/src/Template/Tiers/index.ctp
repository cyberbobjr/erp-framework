<?php $this->assign('title', __('Gestion des tiers')); ?>
<?php $controller = "tiers"; ?>
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

    $()
        .ready(function () {
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
                    return res.clients;
                },
                columns: [
                    {field: 'company_name', title: 'Raison sociale', width: '10%'},
                    {field: 'lastname', title: 'Nom', width: '10%'},
                    {field: 'firstname', title: 'Prénom', width: '10%'},
                    {field: 'address1', title: 'Adresse', width: '20%'},
                    {field: 'zipcode', title: 'Code postal', width: 40},
                    {field: 'city, title: 'Ville', width: 80},
                    {field: 'email', title: 'Courriel', width: '20%'},
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
