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

    <?=
    $this->Html->css([
        'base',
        'bootstrap.min',
        '/font-awesome/css/font-awesome',
        '/js/gritter/css/jquery.gritter',
    ])
    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->Html->script([
        'jquery.min',
        'bootstrap.min',
        'jquery.backstretch.min'
    ]) ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<!--main content start-->
<section class="wrapper">
    <?= $this->fetch('content') ?>
</section>
<script>
    $.backstretch("/img/background.jpg", {speed: 500});
</script>
<!--main content end-->
</body>
</html>
