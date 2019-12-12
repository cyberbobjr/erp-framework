<?php
    /**
     * @var \App\View\AppView $this
     */
?>
<div class="card border-primary">
    <div class="card-header">
        <?= $this->fetch('title') ?>
    </div>
    <div class="card-body">
        <?= $this->fetch('content') ?>
    </div>
    <div class="card-footer">
        <div class="text-right">
            <?= $this->Hooks->getHooks('action') ?>
            <?= $this->fetch('actions') ?>
        </div>
    </div>
</div>
