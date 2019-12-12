<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="panel panel-default panel-primary">
    <div class="panel-heading"><?= __('Opérations') ?></div>
    <?= $this->cell('Operations::displayForUser', [$tier->id]); ?>
</div>