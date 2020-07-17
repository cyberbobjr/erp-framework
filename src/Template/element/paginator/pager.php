<?php
/**
 * @var \App\View\AppView $this
 */
?>
<script type="text/javascript">

    /**
     * Fonction d'édition d'un record
     */
    function edit() {
        var $selected = $("#dt").datagrid("getSelected");
        if (!$selected) {
            return alert('Aucun enregistrement selectionné');
        }
        window.location.href = "<?= $this->Url->build(['controller'=>$controller,'action'=>'add'])?>/" + $selected.id;
    }

    /**
     * Fonction de suppression d'un record
     */
    function delete_record() {
        var $selected = $("#dt").datagrid("getSelected");
        if (!$selected) {
            return alert('Aucun enregistrement selectionné');
        }
        bootbox.confirm("Etes-vous sur de vouloir supprimer cet enregistrement ?", function (value) {
            if (value) {
                $.ajax({
                    url: "<?= $this->Url->build(['controller'=>$controller,'action'=>'delete'])?>/" + $selected.id,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        if (response.result == true) {
                            var $type = "success";
                            $('#dt').datagrid('reload');
                        } else {
                            var $type = "danger";
                        }
                        $.notify({
                            message: response.msg
                        }, {
                            type: $type
                        });
                    }
                })
            }
        })
    }

    /**
     * Fonction d'affichage d'un record
     */
    function view() {
        var $selected = $("#dt").datagrid("getSelected");
        if (!$selected) {
            return alert('Aucun enregistrement selectionné');
        }
        window.location.href = "<?= $this->Url->build(['controller'=>$controller,'action'=>'view'])?>/" + $selected.id;
    }

    $(function () {
        var pager = $('#dt').datagrid().datagrid('getPager');
        pager.pagination({
            buttons: $("#bb")
        });
    })
</script>
<div id="bb">
    <div>
        <?= $this->Html->link('<span class="fa fa-plus"></span>',
            ['controller' => $controller,
             'action'     => 'add'],
            ['class'       => 'btn btn-primary btn-xs',
             'data-toggle' => 'tooltip',
             'title'       => __('Création'),
             'escape'      => FALSE]) ?>
        <?= $this->Html->link('<span class="fa fa-pencil-square-o"></span>',
            '#',
            ['class'       => 'btn btn-default btn-xs',
             'data-toggle' => 'tooltip',
             'onclick'     => 'edit()',
             'title'       => __('Edition'),
             'escape'      => FALSE]) ?>
        <?= $this->Html->link('<span class="fa fa-eye"></span>',
            '#',
            ['class'       => 'btn btn-default btn-xs',
             'data-toggle' => 'tooltip',
             'onclick'     => 'view()',
             'title'       => __('Visualiser'),
             'escape'      => FALSE]) ?>
        <?= $this->Html->link('<span class="fa fa-trash-o"></span>',
            '#',
            ['class'       => 'btn btn-danger btn-xs',
             'data-toggle' => 'tooltip',
             'onclick'     => 'delete_record()',
             'title'       => __('Suppression'),
             'escape'      => FALSE]) ?>
    </div>
</div>