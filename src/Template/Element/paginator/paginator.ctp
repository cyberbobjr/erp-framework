<?php
/**
 * @var \App\View\AppView $this
 */
?>
<script>
    $(document).ready(function () {
        $("a[data-role='paginator").bind("click", function () {
            $.ajax({
                url: this.href
            }).success(function (response) {
                $("#container").html(response);
            });
            return false;
        })
        $("#pagespaginator").bind("change", function () {
                var pagespaginator = $("#pagespaginator").val();
                $.ajax({
                    url: "<?= $this->Paginator->generateUrl()?>",
                    data: {nbpage: pagespaginator}
                }).success(function (response) {
                    $("#container").html(response);
                });
            }
        );
    })
</script>
<!-- Affichage du paginator -->
<?php if (isset($this->Paginator) && $this->Paginator->hasPage()):; ?>
    <?php $limit = $this->request->session()
                                 ->read('Paginator.limit'); ?>
    <div class="row">
        <div class="col-xs-8 col-md-8 col-lg-8">
            <div class="pagination-centered">
                <ul class="pagination">
                    <?= $this->Paginator->numbers(['modulus' => 4,
                                                   'first' => __('Premier'),
                                                   'last' => __('Dernier')]); ?>
                </ul>
            </div>
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
            <?= $this->Form->create(NULL,  ['align' => ['sm' => ['left'   => 6,
                                                                 'middle' => 6,
                                                                 'right'  => 12],
                                                        'md' => ['left'   => 4,
                                                                 'middle' => 4,
                                                                 'right'  => 4]]]); ?>
            <?= $this->Form->input('pagespaginator', ['default' => $limit,
                                                      'label' => __('Limite / pages :'),
                                                      'options' => ['10' => '10',
                                                                    '25' => '25',
                                                                    '50' => '50',
                                                                    '100' => '100']]); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
<?php endif; ?>