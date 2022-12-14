<?php
    /**
     * @var \App\View\AppView $this
     * @var \UserManager\Model\Entity\Group $groupe
     */
    $this->extend('/Common/panel');
    $this->assign('title', $groupe->has('id') ? __('Edition d\'un groupe') : __('Ajout d\'un groupe'));
    $this->start('panel-content');
?>
<?= $this->Form->create($groupe); ?>
<fieldset>
    <?php
        echo $this->Form->input('label');
        echo $this->Form->input('description');
        /** @var \UserManager\Model\Entity\Right[] $rights */
        echo $this->Form->input('rights._ids', ['options' => $rights]);
        /** @var \UserManager\Model\Entity\User[] $users */
        echo $this->Form->input('users._ids', ['options' => $users,
                                               'class'   => 'js-basic-multiple']);
    ?>
</fieldset>
<?php
    $this->end();
    $this->start('footer');
    echo $this->Form->button('<i class="fa fa-check"></i>&nbsp;' . __('Enregistrer'), [
        'class' => [
            'btn',
            'btn-primary',
        ],
    ]);
    echo $this->Form->end();
    $this->end();
?>
