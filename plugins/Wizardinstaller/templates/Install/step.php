<?php $this->extend('/Common/panel') ?>

<?php $this->start('title'); ?>
<?= __('Installation de SCI-Web - Etape {0}', $step) ?>
<?php $this->end(); ?>

<?= $this->element('Install/step' . $step); ?>
