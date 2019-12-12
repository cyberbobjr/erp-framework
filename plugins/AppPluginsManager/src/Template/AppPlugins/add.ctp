<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppPlugin $appPlugin
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List App Plugins'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="appPlugins form large-9 medium-8 columns content">
    <?= $this->Form->create($appPlugin) ?>
    <fieldset>
        <legend><?= __('Add App Plugin') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('activated');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
