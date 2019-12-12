<?php
/**
 * @var \App\View\AppView $this
 */
?>
<script>
    $(document).ready(function () {
        $.growl({
            message: '<?= h($message) ?>',
        }, {
            element: 'body',
            type: "<?= $params['class'] ?>",
            allow_dismiss: true,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 5000,
            url_target: '_blank',
            mouse_over: false,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert" style="padding-right: 40px"><button type="button" class="close" data-growl="dismiss"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><span data-growl="icon"></span><span data-growl="title"></span><span data-growl="message"></span><a href="#" data-growl="url"></a></div>'
        });
    });
</script>
