<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Mot de passe oublié') ?></h3>
    </div>
    <div class="panel-body">
        <div class="well">
            <?= __('Vous avez perdu votre mot de passe, saisissez votre courriel avec lequel vous êtes enregistré, un courriel vous sera envoyé avec un lien de réinitialisation du mot de passe') ?>
        </div>
        <?= $this->Flash->render(); ?>
        <?= $this->Flash->render('auth'); ?>
        <?php
        echo $this->Form->create('User', ['align' => ['sm' => ['left'   => 6,
                                                               'middle' => 6,
                                                               'right'  => 12],
                                                      'md' => ['left'   => 4,
                                                               'middle' => 4,
                                                               'right'  => 4]]]);
        ?>
        <div class="row mt">
            <div class="col-lg-12">
                <?php echo $this->Form->input('courriel', ['required' => 'required',
                                                           'type'     => 'email',
                                                           'error'    => ['class' => 'has-error'],
                                                           'label'    => __('Adresse courriel :'),]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <?php
                echo $this->Form->button('<i class="fa fa-envelope-o"></i>&nbsp;' . __('Envoyer le courriel'),
                                         ['class' => ['btn',
                                                      'btn-theme',
                                                      'btn-primary',
                                                      'center-block',],]);
                ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
