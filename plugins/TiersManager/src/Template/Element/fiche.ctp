<table class="table table-striped">
    <tbody>
    <tr>
        <td><?= __('Raison sociale :') ?></td>
        <td><?= $tier->raison_sociale; ?></td>
    </tr>
    <tr>
        <td><?= __('Nom complet :') ?></td>
        <td><?= $tier->nom_complet; ?></td>
    </tr>
    <tr>
        <td><?= __('Adresse :') ?></td>
        <td><?= $tier->adresse1; ?></td>
    </tr>
    <tr>
        <td><?= __('Complément d\'adresse :') ?></td>
        <td><?= $tier->adresse2; ?></td>
    </tr>
    <tr>
        <td><?= __('Ville :') ?></td>
        <td><?= $tier->code_postal . ' ' . $tier->ville; ?></td>
    </tr>
    <tr>
        <td><?= __('Téléphone fixe :') ?></td>
        <td><?= $tier->telephone_fixe; ?></td>
    </tr>
    <tr>
        <td><?= __('Téléphone mobile :') ?></td>
        <td><?= $tier->telephone_mobile; ?></td>
    </tr>
    <tr>
        <td><?= __('Téléphone société :') ?></td>
        <td><?= $tier->telephone_societe; ?></td>
    </tr>
    <tr>
        <td><?= __('Commentaires :') ?></td>
        <td><?= $tier->commentaires; ?></td>
    </tr>
    <tr>
        <td><?= __('TVA intra :') ?></td>
        <td><?= $tier->tva_intra; ?></td>
    </tr>
    <tr>
        <td><?= __('Courriel :') ?></td>
        <td><?= isset($tier->courriel) ? $this->Html->link($tier->courriel,
                'mailto:' . $tier->courriel,
                ['basePath' => TRUE]) : ""; ?></td>
    </tr>
    </tbody>
</table>