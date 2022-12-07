<?php
/**
 * @var \App\View\AppView $this
 */
$class = 'alert-info';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div class="row">
    <div class="col-xs-12 main-chart">
        <div class="alert <?= h($class) ?> alert-dismissable" role="alert">
            <?= h($message) ?>
            <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        </div>
    </div>
</div>