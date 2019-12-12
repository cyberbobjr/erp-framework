<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#fiche" aria-controls="fiche" role="tab"
               data-toggle="tab"><?= __('Fiche du bail') ?></a>
        </li>
        <li role="presentation">
            <a href="#documents" aria-controls="documents" role="tab"
               data-toggle="tab"><?= __('Documents') ?></a>
        </li>
        <li role="presentation">
            <a href="#soldes" aria-controls="soldes" role="tab"
               data-toggle="tab"><?= __('Transactions') ?></a>
        </li>
    </ul>
</div>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active in fade" id="fiche">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->assign('title', __('Détail du bail - {0}', $bail->designation)); ?>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $this->fetch('title') ?></h3>
                            </div>
                            <div class="panel-body">
                                <?= $this->Element('Bails/fiche'); ?>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= __('Détails du loyer') ?></h3>
                            </div>
                            <div class="panel-body">
                                <?= $this->Element('Loyers/fiche', ['loyer' => $bail->loyer]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= __('Information client') ?></h3>
                            </div>
                            <div class="panel-body">
                                <?= $this->Element('Tiers/fiche', ['tier' => $bail->client]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane in fade" id="documents">
        <?= __('Bientôt disponible') ?>
    </div>
    <div role="tabpanel" class="tab-pane in fade" id="soldes">
        <?= __('Bientôt disponible') ?>
    </div>
</div>