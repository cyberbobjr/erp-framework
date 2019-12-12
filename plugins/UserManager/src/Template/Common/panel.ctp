<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->fetch('content'); ?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title"><?= $this->fetch('title') ?>
            <div class="pull-right"><?= $this->fetch('header'); ?></div>
        </h3>
    </div>
    <div class="panel-body">
        <?= $this->fetch('panel-content'); ?>
    </div>
    <?php if ($this->exists('footer')): ?>
        <div class="panel-footer">
            <div class="text-center">
                <?= $this->fetch('footer'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>