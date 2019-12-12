<table class="table table-striped">
    <tbody>
    <tr>
        <td><?= __('Bail actif :') ?></td>
        <td><?= $bail->actif ? '<i class="fa fa-check label-success"></i>' : '<i class="fa fa-ban label-danger"></i>'; ?></td>
    </tr>
    <tr>
        <td><?= __('Société :') ?></td>
        <td><?= $this->Html->link($bail->societe->raison_sociale, ['controller' => 'Societes',
                                                                   'action'     => 'view',
                                                                   $bail->societe->id]); ?></td>
    </tr>
    <tr>
        <td><?= __('Bien rattaché :') ?></td>
        <td><?= $this->Html->link($bail->bien->designation, ['controller' => 'Biens',
                                                             'action'     => 'view',
                                                             $bail->bien->id]); ?></td>
    </tr>
    <tr>
        <td><?= __('Périodicité du bail :') ?></td>
        <td><?= $bail->type_periodicite->libelle ?></td>
    </tr>
    <tr>
        <td><?= __('Date de début du bail:') ?></td>
        <td><?= $bail->date_debut ?></td>
    </tr>
    <tr>
        <td><?= __('Date de fin du bail:') ?></td>
        <td><?= $bail->date_fin ?></td>
    </tr>
    </tbody>
</table>