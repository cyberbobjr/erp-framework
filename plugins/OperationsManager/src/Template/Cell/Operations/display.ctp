<?php
    /**
     * @var \App\View\AppView $this
     * @var \OperationsManager\Model\Entity\Operation[]|\Cake\Collection\CollectionInterface $operations
     */
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= __('Les 5 dernières opérations') ?></div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
            <tr>
                <td><?= __('Date') ?></td>
                <td><?= __('Libellé') ?></td>
                <td align="center"><?= __('Montant total €') ?></td>
                <td align="center"><?= __('Reste à payer €') ?></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($operations as $operation): ?>
                <tr>
                    <td><?= $operation->created ?></td>
                    <td><?= $this->Html->link($operation->libelle, [
                            'controller' => 'operations',
                            'action'     => 'add',
                            $operation->id
                        ]) ?></td>
                    <td align="center"><?= number_format($operation->total_ttc, 2, ".", " "); ?></td>
                    <td align="center"><?= number_format($operation->solde, 2, ".", " "); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
</div>
