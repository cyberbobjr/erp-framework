<?php
    /**
     * @var \App\View\AppView $this
     */

    use Cake\Core\Configure; ?>
<style>
    nav.navbar {
        border-radius: 0px;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Brand and toggle get grouped for better mobile display -->
    <a class="navbar-brand" href="/"><?= Configure::read('UserManager.sitename') ?></a>
    <div class="navbar-toggler">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="navbar-nav mr-auto">
            <?= $this->Menus->displayMenuFor('left') ?>
        </ul>
        <ul class="navbar-nav">
            <?= $this->Menus->displayMenuFor('right') ?>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
