<div>
<a type="button" class="btn btn-primary btn-sm" aria-label="Left Align" href="<?=
    $this->Url->build([
        'controller' => 'TypeTiers',
        'action' => 'add'
    ])
?>">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><?= __(' Ajouter un type de tiers') ?>
</a>
</div>
<br/>
<table class="table table-bordered table-striped table-condensed">
    <thead>
    <tr>
        <th>#</th>
        <th><?= __('Libellé') ?></th>
        <th><?= __('Sens') ?></th>
        <th><?= __('Compte parent') ?></th>
        <th><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($typetiers as $typetier): ?>
        <tr>
            <td><?= $typetier->id ?></td>
            <td><?= $typetier->libelle ?></td>
            <td><?= $sens[$typetier->sens] ?></td>
            <td><?= $typetier->plan['id'].' - '.$typetier->plan['name'] ?></td>
            <td>
                <a type="button" class="btn btn-primary btn-sm" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="<?= __('Editer le type de tiers') ?>" href="<?=
                    $this->Url->build([
                        'controller' => 'TypeTiers',
                        'action' => 'edit',
                        $typetier->id
                    ])
                ?>">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </a>
                <a type="button" class="btn btn-danger btn-sm confirmation" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="<?= __('Supprimer le type de tiers') ?>" href="<?=
                    $this->Url->build([
                        'controller' => 'TypeTiers',
                        'action' => 'delete',
                        $typetier->id
                    ])
                ?>">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>