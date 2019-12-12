<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\User $user
     */
?>
<?= $this->Html->script('image-picker.min') ?>
<?= $this->Html->css('image-picker') ?>
<?php
    $this->assign('title', __('Création d\'un utilisateur'));
    $this->extend('/Common/panel');
?>
<script>
    $(document)
        .ready(function () {
            $("select.image-picker")
                .imagepicker();
        })
</script>

<div class="row">
    <div class="col-xs-8 center-block">
        <?php
            echo $this->Form->create($user, [
                'role'  => 'form-role',
                'class' => 'form-horizontal'
            ]);
            echo $this->Form->input('username', [
                'label' => [
                    'text'  => __('Login utilisateur :'),
                    'class' => 'col-xs-5 control-label required'
                ]
            ]);
            echo $this->Form->input('nomcomplet', [
                'label' => [
                    'text'  => __('Nom complet :'),
                    'class' => 'col-xs-5 control-label required'
                ]
            ]);
            echo $this->Form->input('password', [
                'label' => [
                    'text'  => __('Mot de passe :'),
                    'class' => 'col-xs-5 control-label required'
                ]
            ]);
            echo $this->Form->input('password_confirm', [
                'type'  => 'password',
                'label' => [
                    'text'  => __('Confirmer le mot de passe :'),
                    'class' => 'col-xs-5 control-label required'
                ]
            ]);
            echo $this->Form->input('courriel', [
                'error' => ['class' => 'has-error'],
                'label' => [
                    'text'  => __('Adresse courriel :'),
                    'class' => 'col-xs-5 control-label'
                ]
            ]);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-7 center-block">
        <select class="image-picker" name="avatar">
            <?php foreach ($avatars as $avatar): ?>
                <option data-img-src='/img/avatars/<?= $avatar ?>'
                        value='<?= $avatar ?>'><?= $avatar ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-2 center-block">
        <?php
            echo $this->Form->button(__('Enregistrer'), [
                'class' => [
                    'btn',
                    'btn-default'
                ]
            ]);
            echo $this->Form->end();
        ?>
    </div>
</div>
