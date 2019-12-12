<?php $this->assign('title', __('Liste des loyers'));?>
<script>
    function printFormater(value) {
        var $url = "<?= $this->Url->build(['controller'=>'Comptes','action'=>'view'])?>";
        $url = $url + '/' + value + '.pdf';
        return '<a target="_blank" href="' + $url + '"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>';
    }
</script>
<?= $this->element('script/toolbar', ['toolbar' => ['add'    => false,
                                                    'edit'   => true,
                                                    'view'   => true,
                                                    'remove' => true,]]) ?>

<br/>
<table id="table-data"
       data-toggle="table" class="table table-condensed table-hover table-striped" data-search="true"
       data-show-refresh="true"
       data-show-toggle="false"
       data-show-columns="true"
       data-toolbar="#toolbar"
       data-show-pagination-switch="true"
       data-pagination="true"
       data-page-size="10"
       data-page-list="[5, 10, 20]"
       data-query-params="queryParams"
       data-card-view="false"
       data-click-to-select="true"
       data-flat="true"
       data-select-item-name="myRadioName"
       data-url="<?= $this->Url->build([
           'action' => 'table',
       ]) ?>">
    <thead>
    <tr>
        <th data-field="state" data-radio="true"></th>
        <th data-field="id" data-sortable="true">#</th>
        <th data-field="created" data-formatter="dateFormater" data-sortable="true"><?= __('Date de création') ?></th>
        <th data-field="societe.raison_sociale" data-sortable="true"><?= __('Société') ?></th>
        <th data-field="numero" data-sortable="true"><?= __('Numéro de compte') ?></th>
        <th data-field="libelle" data-sortable="true"><?= __('Libellé du compte') ?></th>
        <th data-field="solde" data-formatter="currencyFormater" class="text-center" data-sortable="true"><?= __('Solde du compte') ?></th>
        <th data-field="id" data-formatter="printFormater"></th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>