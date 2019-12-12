<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\AppPlugin[]|\Cake\Collection\CollectionInterface $appPlugins
     */
?>
<script>
    $(function () {
        $('input[data-toggle="toggle"]')
            .change(function () {
                window.location.href = "<?= \Cake\Routing\Router::url(['action' => 'toggleActivate'])?>/" + this.getAttribute('data-id');
            })
    })
</script>
<nav class="col-md-3" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New App Plugin'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="appPlugins col-md-9">
    <h3><?= __('App Plugins') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('activated') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($appPlugins as $appPlugin): ?>
            <tr>
                <td><?= $this->Number->format($appPlugin->id) ?></td>
                <td><?= h($appPlugin->name) ?></td>
                <td><?= $this->Form->control(NULL, ['checked'     => $appPlugin->activated,
                                                    'data-size'   => 'mini',
                                                    'data-id'     => $appPlugin->id,
                                                    'type'        => 'checkbox',
                                                    'data-toggle' => 'toggle']) ?></td>
                <td><?= h($appPlugin->created) ?></td>
                <td><?= h($appPlugin->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view',
                                                       $appPlugin->id], ['class' => 'btn btn-xs btn-primary']) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit',
                                                       $appPlugin->id], ['class' => 'btn btn-xs btn-primary']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete',
                                                             $appPlugin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appPlugin->id),
                                                                               'class'   => 'btn btn-xs btn-danger']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< '.__('first')) ?>
            <?= $this->Paginator->prev('< '.__('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next').' >') ?>
            <?= $this->Paginator->last(__('last').' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
