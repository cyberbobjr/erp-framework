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
    <?php
        echo $this->Html->css('BootstrapUI.bootstrap.min');
        echo $this->Html->css(['BootstrapUI./font/bootstrap-icons', 'BootstrapUI./font/bootstrap-icon-sizes']);
        echo $this->Html->script(['BootstrapUI.popper.min', 'BootstrapUI.bootstrap.min']);
    ?>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['fullcalendar',
                          'themes/metro/easyui',
                          'themes/icon',
                          'themes/color',
                          'font-awesome.min',
                          'jquery.gritter',
                          '/lineicons/style',
                          'animate',
                          'bootstrap',
                          'bootstrap-table',
                          'bootstrap-table-filter-control',
                          'bootstrap-submenu.min',
                          'bootstrap-table-sticky-header',
                          'bootstrap-datepicker',
                          'bootstrap-toggle.min',
                          'base',]) ?>
    <?= $this->Html->script(['sci',
                             'moment.min',
                             'jquery',
                             'jquery.numeric',
                             'bootstrap.min',
                             'bootstrap-datepicker',
                             'bootstrap-datepicker.fr',
                             'jquery.cookie',
                             'jquery.easyui.min',
                             'jquery.ui.widget',
                             'jquery.iframe-transport',
                             'jquery.fileupload',
                             'bootbox.min',
                             'bootstrap-submenu.min',
                             'bootstrap-table',
                             'bootstrap-table-filter',
                             'bootstrap-table-filter-control',
                             'bootstrap-table-locale-all',
                             'bootstrap-table-flat-json',
                             'bootstrap-table-sticky-header',
                             'bootstrap-toggle.min',
                             'moment-with-locales.min',
                             '/highcharts/highcharts',
                             'fullcalendar',
                             'locale-all',
                             'SimpleChart']) ?>

    <?= $this->Html->script(['jquery.knob',
                             'jquery.ui.widget',
                             'jquery.iframe-transport',
                             'jquery.fileupload',
                             'script']); //<= Pour l'upload des documents tiers                  ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<style>
    .datagrid-row-selected .numberbox {
        color: #000000;
    }

    .datagrid-row-selected span {
        color: white;
    }

    .datagrid-row-selected a {
        color: white;
    }

</style>
<script type="application/javascript">
    /**
     * Fonction d'initialisation de tous les composants qui ont le role datepicker
     */
    function initDatePicker() {
        $('input[data-role="datepicker"]')
            .datepicker({
                autoclose: true,
                language: "fr",
                format: "dd/mm/yyyy",
                todayBtn: true,
                todayHighlight: true
            });
    }

    function initTooltip() {
        $('body')
            .tooltip({
                selector: '[data-toggle="tooltip"]'
            });
    }

    $()
        .ready(function () {
            initDatePicker();
            initTooltip();
            $('[data-submenu]')
                .submenupicker();
            bootbox.setLocale("fr");

            $(".alert")
                .addClass('animated fadeIn');

            $('.confirmation')
                .on('click', function (event) {
                    return confirm('Etes-vous sûr ?');
                });
            $("button.close")
                .on('click', function () {
                    $("div[role='alert']")
                        .removeClass('fadeIn')
                        .addClass('fadeOut');
                    $("div[role='alert']")
                        .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            $("div[role='alert']")
                                .remove();
                        });
                    return false;
                });
        });
</script>
<div id="dummy"></div>
<!-- **********************************************************************************************************************************************************
TOP BAR CONTENT & NOTIFICATIONS
*********************************************************************************************************************************************************** -->
<!--header start-->
<?= $this->element('navbar') ?>
<!--header end-->

<!-- **********************************************************************************************************************************************************
MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
<!--sidebar start-->

<!--main content start-->
<div class="container-fluid">
    <?= $this->Flash->render() ?>
    <?= $this->Flash->render('auth') ?>
    <div class="row-fluid mt-3" id="container">
        <?= $this->fetch('content') ?>
    </div>
</div>
<!--main content end-->


<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        2019 - B.Marchand
        <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->
</body>
</html>
