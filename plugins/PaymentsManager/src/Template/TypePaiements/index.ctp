<?php $this->assign('title', __('Type de paiements'));?>

<div id="toolbar" class="btn-group">
    <a type="button" class="btn btn-primary btn-sm"
       data-toggle="tooltip" data-placement="top" title="<?= __('Créer un type d\'opération') ?>"
       aria-label="Left Align" href="<?=
    $this->Url->build([
                          /*'controller' => 'TypeOperations',*/
                          'action' => 'add'
                      ])
    ?>">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </a>
    <a type="button" class="btn btn-primary btn-sm" id="editBtn" disabled
       data-toggle="tooltip" data-placement="top" title="<?= __('Editer le type') ?>"
       aria-label="Left Align" href="<?=
    $this->Url->build([
                          /*'controller' => 'TypeOperations',*/
                          'action' => 'edit'
                      ])
    ?>">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    </a>
    <a type="button" class="btn btn-danger btn-sm" id="removeBtn" disabled
       data-toggle="tooltip" data-placement="top" title="<?= __('Supprimer le type') ?>"
       aria-label="Left Align" href="<?=
    $this->Url->build([
                          /*'controller' => 'TypeOperations',*/
                          'action' => 'delete'
                      ])
    ?>">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
    </a>
</div>
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
                                           'action' => 'table'
                                       ]) ?>">    <thead>
    <tr>
        <th data-field="state" data-radio="true"></th>
        <th data-field="id" data-sortable="true">#</th>
        <th data-field="libelle" data-sortable="true"><?= __('Libellé') ?></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>