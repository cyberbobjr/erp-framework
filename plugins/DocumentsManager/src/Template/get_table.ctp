<script>
    function supprimer(el) {
        var $document_id = $(el).data("doc-id");
        $.ajax({
            url: "<?=  $this->Url->build(['controller' => 'documentstiers',
                                          'action'     => 'supprimer'])?>",
            type: 'post',
            dataType: 'json',
            data: {document_id: $document_id},
            success: function (json) {
                bootbox.alert(json.body);
                $(el).closest("tr").hide();
            },
            error: function (json) {
                bootbox.alert('Erreur de suppression');
            }
        });
    }
</script>
<table class="table table-striped">
    <thead>
    <tr>
        <td><?= __('Date') ?></td>
        <td><?= __('Nom du fichier') ?></td>
        <td><?= __('Libellé') ?></td>
        <td><?= __('Type de document') ?></td>
        <td><?= __('Action') ?></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($documents as $document) : ?>
        <tr>
            <td><?= $document->created; ?></td>
            <td><?= $document->file; ?></td>
            <td><?= $this->Html->link($document->libelle, ['controller' => 'documentstiers',
                                                           'action'     => 'download',
                                                           $document->id], ['target' => '_blank']); ?></td>
            <td><?= $document->type_documentstier->libelle; ?></td>
            <td>
                <button type="button" class="btn btn-danger btn-xs" aria-label="Left Align"
                        data-doc-id="<?= $document->id ?>"
                        onclick="supprimer(this)">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
