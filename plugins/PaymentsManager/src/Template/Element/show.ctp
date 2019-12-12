<div class="panel panel-default panel-primary">
    <div class="panel-heading"><?= __('Réglements') ?></div>
    <?= $this->cell('Reglements::displayForUser', [$tier->id]); ?>
</div>