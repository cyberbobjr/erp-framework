<?php
/**
 * @var \App\View\AppView $this
 */
$this->extend('/Common/panel');
$this->assign('title', $droit->has('id') ? __('Edition d\'un droit') : __('Ajout d\'un droit'));
$this->start('panel-content');
?>
<?= $this->Form->create($droit, [
    'align' => ['sm' => ['left'   => 6,
                         'middle' => 6,
                         'right'  => 12],
                'md' => ['left'   => 3,
                         'middle' => 6,
                         'right'  => 12
                ]
    ]]); ?>
    <fieldset>
        <legend><?= __('Edition d\'un droit') ?></legend>
        <?php
        echo $this->Form->input('code');
        echo $this->Form->input('libelle');
        echo $this->Form->input('groupes._ids', ['options' => $groupes]);
        ?>
    </fieldset>
<?= $this->Form->button(__('Enregistrer')); ?>
<?= $this->Form->end() ?>
<?php $this->end(); ?>