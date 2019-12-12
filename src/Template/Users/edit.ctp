<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $this->Html->script('image-picker.min'); ?>
<?= $this->Html->css('image-picker'); ?>
<?php
    $myTemplates = [
        'checkboxFormGroup' => '<div class="col-xs-offset-5 col-xs-5"><div class="checkbox">{{label}}</div></div>',
        /*'checkbox'            => '<input type="checkbox" value="{{value}}" {{attrs}}>',*/
        'checkboxWrapper' => '<div class="form-group"><div class="col-sm-offset-5 col-xs-7">{{label}} {{input}}</div></div>',
        'inputContainer' => '<div class="form-group" {{required}} >{{content}}</div>',
        'input' => '<div class="col-sm-10"><input class="form-control input-sm" type="{{type}}" name="{{name}}" {{attrs}}></div>',
        'label' => '<label {{attrs}} class="col-sm-2 col-sm-2 control-label">{{text}}</label>',
        'select' => '<div class="col-xs-10"><select class="form-control input-sm" {{attrs}} name={{name}}>{{content}}<select></div>',
        'error' => '<p class="text-danger">{{content}}</p>',
        'textarea' => '<div class="col-xs-7"><textarea class="form-control input-sm" name="{{name}}" {{attrs}}>{{value}}</textarea>',
        'inputContainerError' => '<div class="form-group has-error" {{required}}>{{content}}</div>{{error}}',
    ];
    $this->Form->templates($myTemplates);

    $this->assign('title', __('Edition d\'un utilisateur'));
    $this->extend('/Common/panel');
?>
<style>
    .center-block {
        float: none;
    }
</style>
<script>
    $(document).ready(function () {
        $("select.image-picker").imagepicker();
    })
</script>
<div class="row mt">
    <div class="col-lg-12">
        <?php
            echo $this->Form->create($user, [
                'role' => 'form-role',
                'class' => 'form-horizontal style-form'
            ]);
            echo $this->Form->input('username', [
                'label' => __('Login utilisateur :')
            ]);
            echo $this->Form->input('nomcomplet', [
                'label' => __('Nom complet :'),
            ]);
            echo $this->Form->input('password', [
                'label' => __('Mot de passe :')
            ]);
            echo $this->Form->input('password_confirm', [
                'type' => 'password',
                'label' =>
                    __('Confirmer le mot de passe :')
            ]);
            echo $this->Form->input('courriel', [
                'error' => ['class' => 'has-error'],
                'label' => __('Adresse courriel :')
            ]);
        ?>
        <div class="col-xs-10 col-lg-offset-2">
            <select class="image-picker" name="avatar">
                <?php foreach ($avatars as $avatar): ?>
                    <?php ($avatar == $user->avatar) ? $selected = 'selected' : $selected = ''; ?>
                    <option <?= $selected ?> data-img-src='/img/avatars/<?= $avatar ?>'
                                             value='<?= $avatar ?>'><?= $avatar ?></option>
                <?php endforeach; ?>
            </select>
            <?php
                if (!empty($user->avatar)) {
                    echo $this->Html->image('avatars' . DS . $user->avatar);
                }
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-2 center-block">
        <?php
            echo $this->Form->button('<i class="fa fa-check"></i> ' . __('Enregistrer'), [
                'class' => [
                    'btn',
                    'btn-theme'
                ]
            ]);
            echo $this->Form->end();
        ?>
    </div>
</div>
