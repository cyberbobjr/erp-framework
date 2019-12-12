<?php $this->assign('title', __('Liste des paiements'));?>
<?= $this->element('script/toolbar', ['toolbar' => ['add'    => false,
                                                    'edit'   => false,
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
                                           'action'     => 'table'
                                       ]) ?>">
    <thead>
    <tr>
        <th data-field="state" data-checkbox="true"></th>
        <th data-field="id" data-sortable="true">#</th>
        <th data-field="date" data-formatter="dateFormater" data-sortable="true"><?= __('Date') ?></th>
        <th data-field="tier.nom_complet" data-sortable="true"><?= __('Tiers') ?></th>
        <th data-field="sens" class="center-text" data-formatter="senspaiementFormater"
            data-sortable="true"><?= __('Sens') ?></th>
        <th data-field="banque.designation" data-sortable="true"><?= __('Banque') ?></th>
        <th data-field="type_paiement.libelle" data-sortable="true"><?= __('Type de paiement') ?></th>
        <th data-field="totalttc" data-formatter="currencyFormater" class="center-text"><?= __('Montant (€)') ?></th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>