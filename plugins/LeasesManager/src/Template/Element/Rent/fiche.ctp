<?php

    use Cake\I18n\Number;

?>
<table class="table table-striped">
    <thead>
    <tr>
        <th><?= __('Libellé de la ligne de loyer') ?></th>
        <th><?= __('Type de prestation') ?></th>
        <th><?= __('Montant HT') ?></th>
        <th><?= __('TVA') ?></th>
        <th><?= __('Montant TTC') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($loyer->loyerdetails as $loyerdetail): ?>
        <tr>
            <td><?= $loyerdetail->libelle ?></td>
            <td><?= $loyerdetail->type_operation->libelle ?></td>
            <td><?= Number::currency($loyerdetail->montant_ht) ?></td>
            <td><?= Number::currency($loyerdetail->montant_tva) ?></td>
            <td><?= Number::currency($loyerdetail->montant_ttc) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot style="border-top: double">
    <tr style="font-weight: bold">
        <td colspan="2"><?= __('Total') ?></td>
        <td><?= Number::currency($loyer->total_ht) ?></td>
        <td><?= Number::currency($loyer->total_tva) ?></td>
        <td><?= Number::currency($loyer->total_ttc) ?></td>
    </tr>
    </tfoot>
</table>
