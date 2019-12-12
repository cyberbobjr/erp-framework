<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#fiche" aria-controls="fiche" role="tab"
               data-toggle="tab"><?= __('Fiche client') ?></a>
        </li>
        <li role="presentation">
            <a href="#documents" aria-controls="documents" role="tab"
               data-toggle="tab"><?= __('Documents') ?></a>
        </li>
        <li role="presentation">
            <a href="#soldes" aria-controls="soldes" role="tab"
               data-toggle="tab"><?= __('Solde du tiers') ?></a>
        </li>
        <li role="presentation">
            <a href="#notes" aria-controls="notes" role="tab"
               data-toggle="tab"><?= __('Notes') ?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active in fade" id="fiche">
            <div class="row">
                <div class="col-xs-7">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->Element('Tiers/fiche') ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-5">
                    <div class="row">
                        <?= $this->element('Reglements/show'); ?>
                    </div>
                    <div class="row">
                        <?= $this->element('Operations/show'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="documents">
            <?= $this->element('Documenttiers/fiche'); ?>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="soldes">A venir...</div>
        <div role="tabpanel" class="tab-pane fade" id="notes">A venir...</div>
    </div>

</div>