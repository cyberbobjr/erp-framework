<?php
/**
 * @var \App\View\AppView $this
 */
$myTemplates = [
    'inputContainer' => '{{content}}',
    'input'          => '<input type="{{type}}" name="{{name}}" {{attrs}}>',

];
$this->Form->templates($myTemplates);
?>

<?= $this->Form->create('user', [
    'role'  => 'form-role',
    'class' => 'form-login'
]);
?>
    <h2 class="form-login-heading"><?= __('Connection') ?></h2>
    <div class="login-wrap">
        <?= $this->Flash->render('auth') ?>
        <?= $this->Flash->render() ?>

        <?= $this->Form->input('username', ['label' => FALSE, 'div' => false, 'class' => 'form-control', 'placeholder' => 'Login']); ?>
        <br/>
        <?= $this->Form->input('password', ['label' => FALSE, 'div' => false, 'class' => 'form-control', 'placeholder' => __('Mot de passe')]); ?>
        <br/>
        <?= $this->Form->button('<i class="fa fa-lock"></i>' . __(' SE CONNECTER'), ['class' => 'btn btn-theme btn-block']) ?>
    </div>
<?= $this->Form->end(); ?>