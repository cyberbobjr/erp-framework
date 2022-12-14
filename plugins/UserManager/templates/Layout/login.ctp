<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

    use Cake\Core\Configure;

    if (Configure::check('UserManager.background')) {
    $background = Configure::read('UserManager.background');
}
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['UserManager.font-awesome.min',
                          'UserManager.wfont-google',
                          'UserManager.yeti.min']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <?= $this->Html->script(['UserManager.jquery-1.11.3.min',
                             'UserManager.bootstrap.min',
                             'UserManager.jquery.backstretch.min']) ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<style>
    .form-group.required .control-label:after {
        content: " *";
        color: red;
    }

    .form-group.required label:after {
        content: " *";
        color: red;
    }
</style>
<!--main content start-->
<div class="container-fluid">
    <?php echo $this->Flash->render(''); ?>
    <?php echo $this->Flash->render('auth'); ?>
    <div class="row-fluid">
        <div class="col-lg-12">
            <br/>
            <?= $this->fetch('content') ?>
        </div>
    </div>
</div>
<?php if (isset($background)): ?>
    <script>
        $.backstretch("<?= $this->Url->build('/img/' . $background)?>", {speed: 500});
    </script>
<?php endif; ?>
<!--main content end-->
</body>
</html>
