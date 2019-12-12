<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppPlugin $appPlugin
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit App Plugin'), ['action' => 'edit', $appPlugin->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete App Plugin'), ['action' => 'delete', $appPlugin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appPlugin->id)]) ?> </li>
        <li><?= $this->Html->link(__('List App Plugins'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New App Plugin'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="appPlugins view large-9 medium-8 columns content">
    <h3><?= h($appPlugin->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($appPlugin->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($appPlugin->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($appPlugin->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($appPlugin->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Activated') ?></th>
            <td><?= $appPlugin->activated ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
