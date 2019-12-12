<?php
/**
 * @var \App\View\AppView $this
 */

    use Cake\Core\Configure;

?>
    <style>
        .img-responsive {
            margin: 0 auto;
        }
    </style>
<?= $this->Form->create('user'); ?>
    <div class="row form-login">
        <div class="col-sm-offset-2 col-md-offset-3 col-lg-offset-4 col-lg-4 col-md-6 col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="modal-title"><?= Configure::read('UserManager.sitename') . ' ' . __(' - Bienvenue') ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if (Configure::check('UserManager.logo')) : ?>
                            <div class="col-xs-12 text-center">
                                <?= $this->Html->image(Configure::read('UserManager.logo'),
                                    ['class' => 'img-responsive']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <?= $this->Flash->render(); ?>
                            <?= $this->Flash->render('auth'); ?>
                        </div>
                    </div>
                    <?= $this->Form->input('username', ['label'       => FALSE,
                                                        'placeholder' => __('Login de connexion'),]); ?>
                    <?= $this->Form->input('password', ['label'       => FALSE,
                                                        'placeholder' => __('Mot de passe'),]); ?>
                    <?= $this->Form->button('<i class="fa fa-lock"></i>' . __(' CONNEXION'),
                        ['class' => 'btn btn-primary btn-block']) ?>
                    <?php if (Configure::read('UserManager.social_login') === TRUE) : ?>
                        <?= $this->Html->link('<i class="fa fa-google-plus"></i>&nbsp;' . __('Se connecter avec Google'),
                            ['controller' => 'Users',
                             'plugin'     => 'UserManager',
                             'action'     => 'googleLogin'],
                            ['class'  => 'btn btn-block btn-social btn-md btn-google-plus',
                             'escape' => FALSE]) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(__('Mot de passe oublié ?'), ['action' => 'lost_password']); ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"><?= __('Se souvenir de moi') ?>
                        </label>
                    </div>
                    <?php if (Configure::read('UserManager.register') === TRUE) : ?>
                        <hr/>
                        <?= $this->Html->link(__('Pas encore de compte ? inscrivez-vous !'), ['plugin'     => 'UserManager',
                                                                                              'action'     => 'register',
                                                                                              'controller' => 'users']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?= $this->Form->end(); ?>
