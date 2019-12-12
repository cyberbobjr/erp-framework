<?php
    /**
     * @var AppView $this
     * @var Customer $customer
     */

    use App\View\AppView;
    use TiersManager\Model\Entity\Customer;

?>
<?php $this->extend('/Common/panel'); ?>

<?php $this->start('title') ?>
<?= __('Ajouter un client') ?>
<?php $this->end() ?>

<fieldset>
    <?= $this->Form->create($customer) ?>
    <?= $this->Hooks->getHooks('beforeinputs') ?>
    <?= $this->Utility->entityControl($customer) ?>
    <?= $this->Hooks->getHooks('afterinputs') ?>
</fieldset>

<?php $this->start('actions') ?>
<?= $this->Form->button(__('Ajouter le client'), ['class' => 'btn btn-primary btn-sm']) ?>
<?= $this->Form->end() ?>
<?php $this->end() ?>
