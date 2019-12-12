<script>
    $().ready(function () {

        $(".sendDoc").bind('click', function (ev) {
            $("#documentId").val($(this).data('document-id'));
            $("#subjectId").val($(this).data('document-libelle'));
            $("#courrielModal").modal('show').find('input,textarea').attr('disabled', false);

            ev.preventDefault();
            return false;
        });

        $("#sendmailBtn").bind('click', function (ev) {
            $.ajax({
                url: "<?=$this->Url->build(['controller' => 'documents',
                                            'action'     => 'sendcourriel'])?>",
                data: {
                    document_id: $("#documentId").val(),
                    message: $("#messageId").val(),
                    subject: $("#subjectId").val(),
                    courriel: $("#courrielId").val()
                },
                type: 'POST',
                dataType: 'json',
                success: function (json) {
                    if (json.error) {
                        $type = 'danger';
                    } else {
                        $type = 'success';
                    }
                    $.notify({
                        // options
                        message: json.msg
                    }, {
                        // settings
                        type: $type
                    });
                    $("#courrielModal").modal('hide');
                }
            });
        })
    })
</script>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td><?= __('Date') ?></td>
        <td><?= __('Fichier') ?></td>
        <td align="center"><?= __('Action') ?></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($documents as $document): ?>
        <tr>
            <td><?= $this->Time->format($document->modified, 'dd/MM/yyyy') ?></td>
            <td><?= $document->libelle ?></td>
            <td align="center">
                <?= $this->Html->link('<i class="fa fa-envelope-o"></i>', '#', ['escape'                => FALSE,
                                                                                'class'                 => 'sendDoc btn btn-default btn-xs',
                                                                                'data-toggle'           => 'tooltip',
                                                                                'data-document-id'      => $document->id,
                                                                                'data-document-libelle' => $document->libelle,
                                                                                'title'                 => __('Envoyer le document par courriel'),]) ?>
                <?= $this->Html->link('<i class="fa fa-file-pdf-o"></i>', ['controller' => 'documents',
                                                                           'action'     => 'download',
                                                                           $document->id], ['escape'      => FALSE,
                                                                                            'class'       => 'btn btn-default btn-xs',
                                                                                            'data-toggle' => 'tooltip',
                                                                                            'title'       => __('Visualiser le document'),
                                                                                            'target'      => "_blank",
                                                                                            'style'       => 'color:red']) ?>
                <?= $this->Utility->postLinkBoostrap('<i class="fa fa-trash-o"></i>', ['controller' => 'documents',
                                                                                       'action'     => 'delete',
                                                                                       $document->id],
                                                     ['title'       => __('Supprimer définitivement le document'),
                                                      'data-toggle' => 'tooltip',
                                                      'block'       => 'postLink',
                                                      'data'        => ['operation_id' => $operation->id],
                                                      'escape'      => FALSE,
                                                      'confirm'     => __('Êtes-vous sûr de vouloir supprimer ce document ? Cette action est irreversible.'),
                                                      'class'       => 'btn btn-danger btn-xs',
                                                      'type'        => 'button']); ?>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<!-- Modal envoi de mail -->
<div class="modal fade" id="courrielModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <?= $this->Form->create(NULL, ['id' => 'emailForm']); ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= __('Envoyer le document par courriel') ?></h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->input('courriel', ['id'    => 'courrielId',
                                                    'value' => $operation->client->courriel,
                                                    'label' => __('Courriel du destinataire :'),]); ?>
                <?= $this->Form->input('subject', ['id'    => 'subjectId',
                                                   'type'  => 'text',
                                                   'label' => __('Sujet :'),]) ?>
                <?= $this->Form->input('body', ['id'    => 'messageId',
                                                'type'  => 'textarea',
                                                'label' => __('Message :'),
                                                'value' => __("Bonjour,\nveuillez trouver en pièce jointe le document demandé.\nCordialement."),]) ?>
                <?= $this->Form->input('document_id', ['type' => 'hidden',
                                                       'id'   => 'documentId',]); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('Annuler') ?></button>
                <button type="button" class="btn btn-primary" id="sendmailBtn"><?= __('Envoyer') ?></button>
            </div>
        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>
<!-- postlink -->
<?= $this->fetch('postLink'); ?>
