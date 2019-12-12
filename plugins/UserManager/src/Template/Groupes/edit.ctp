<?php
    /**
     * @var \App\View\AppView $this
     * @var \UserManager\Model\Entity\Groupe $groupe
     */
?>
<?= $this->Form->create($groupe); ?>
<fieldset>
    <?php
        echo $this->Form->input('label');
        echo $this->Form->input('description');
        /** @var \UserManager\Model\Entity\Right[] $rights */
        echo $this->Form->input('rights._ids', [
            'options' => $rights,
            'class'   => 'js-basic-multiple']);
        echo $this->Form->input('users._ids', [
            'options' => $users,
            'class'   => 'js-basic-multiple']);
    ?>
</fieldset>
<?= $this->Form->button(__("Enregistrer")); ?>
<?= $this->Form->end() ?>
