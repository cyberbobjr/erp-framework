<script>
    function refresh_docs() {
        $.ajax({
            url: "<?=  $this->Url->build(['controller' => 'documentstiers',
                                          'action'     => 'index',
                                          $tier->id])?>",
            type: 'get',
            dataType: 'html',
            success: function (html) {
                $("#documentstierstable")
                    .html(html);
            }
        });
    }

    $(function () {
        refresh_docs();

        $('#fileupload')
            .fileupload({
                dataType: 'json',
                add: function (e, data) {
                    $('#buttonUpload')
                        .html("");
                    data.context = $('<button class="btn btn-success"/>')
                        .text('Envoyer')
                        .appendTo($('#buttonUpload'))
                        .click(function () {
                            if ($("#libelle")
                                .val().length == 0) {
                                bootbox.alert("Le champ libellé est obligatoire");
                                return;
                            }
                            data.context = $('<p/>')
                                .text('Envoi en cours...')
                                .replaceAll($(this));
                            data.submit();
                        });
                },
                done: function (e, data) {
                    data.context.text('Envoi terminé.');
                    refresh_docs();
                },
                fail: function (e, data) {
                    data.context.text('Echec de l\'envoi.');
                }
            });
    })
</script>
<div class="row">
    <div class="col-xs-7" id="documentstierstable">
    </div>
    <div class="col-xs-5">
        <?= $this->Form->create(NULL, ['type'       => 'file',
                                       'id'         => 'fileupload',
                                       'url'        => ['controller' => 'documentstiers',
                                                        'action'     => 'add',
                                                        $tier->id],
                                       'horizontal' => TRUE]) ?>
        <?= $this->Form->input('tier_id', ['type'  => 'hidden',
                                           'value' => $tier->id]) ?>
        <?= $this->Form->input('bail_id', ['type'  => 'hidden',
                                           'value' => isset($bail) ? $bail->id : NULL]) ?>
        <?= $this->Form->input('type_documentstier_id', ['options' => $type_documentstiers,
                                                         'label'   => __('Type de document')]) ?>
        <?= $this->Form->control('libelle', ['type'  => 'string',
                                             'class' => 'input-sm',
                                             'required',
                                             'label' => __('Titre du document')]) ?>
        <?= $this->Form->control('file', ['type'  => 'file',
                                          'label' => __('Choisissez le fichier à ajouter')]) ?>
        <div id="buttonUpload" class="text-center"></div>
        <?= $this->Form->end() ?>
    </div>
</div>
