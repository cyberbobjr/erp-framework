<?php
/**
 * @var \App\View\AppView $this
 * @var \UserManager\Model\Entity\User $user
 */

    use Cake\Core\Configure;

    if (Configure::check('UserManager.sitename')) {
    $sitename = Configure::read('UserManager.sitename');
} else {
    $sitename = NULL;
}
if (Configure::check('UserManager.logo')) {
    $logo = Configure::read('UserManager.logo');
} else {
    $logo = NULL;
}
?>
<div id="mailsub" class="notification" align="center">
    <table style="min-width: 320px;" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td align="center" bgcolor="#eff3f8"><!-- [if gte mso 10]>
                <table width="680" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                <![endif]-->
                <table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" width="100%"
                       cellspacing="0" cellpadding="0">
                    <tbody>
                    <!--header -->
                    <tr>
                        <td align="center" bgcolor="#ffffff">
                            <!-- padding -->
                            <table border="0" width="90%" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <!-- Item -->
                                        <div class="mob_center_bl"
                                             style="float: left; display: inline-block; width: 115px;">
                                            <table class="mob_center" style="border-collapse: collapse;" border="0"
                                                   width="115" cellspacing="0" cellpadding="0" align="left">
                                                <tbody>
                                                <tr>
                                                    <td align="left" valign="middle"><!-- padding -->
                                                        <div style="height: 20px; line-height: 20px; font-size: 10px;">
                                                            &nbsp;</div>
                                                        <table border="0" width="115" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                            <tr>
                                                                <td class="mob_center" align="left" valign="top"><a
                                                                        style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"
                                                                        href="<?= $this->Url->build('/', TRUE) ?>"
                                                                        target="_blank">
                                                                        <span
                                                                            style="color: #596167; font-size: medium;">
                                                                            <?= !is_null($logo) ? $this->Html->image($logo,
                                                                                                                     [
                                                                                                                         'style'    => 'width:230px',
                                                                                                                         'border'   => 0,
                                                                                                                         'fullBase' => TRUE]) : '' ?>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Item END--><!-- [if gte mso 10]>
                                        </td>
                                        <td align="right">
                                        <![endif]--><!--

				Item -->
                                        <div class="mob_center_bl"
                                             style="float: right; display: inline-block; width: 88px;">
                                            <table style="border-collapse: collapse;" border="0" width="88"
                                                   cellspacing="0" cellpadding="0" align="right">
                                                <tbody>
                                                <tr>
                                                    <td align="right" valign="middle"><!-- padding -->
                                                        <div style="height: 20px; line-height: 20px; font-size: 10px;">
                                                            &nbsp;</div>
                                                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                            <tr>
                                                                <td align="right"><!--social -->
                                                                    <div class="mob_center_bl" style="width: 88px;">
                                                                        <table border="0" cellspacing="0"
                                                                               cellpadding="0">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 19px;"
                                                                                    align="center" width="30">
                                                                                </td>
                                                                                <td style="line-height: 19px;"
                                                                                    align="center" width="39">
                                                                                </td>
                                                                                <td style="line-height: 19px;"
                                                                                    align="right" width="29">
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <!--social END--></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Item END--></td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- padding -->
                            <div style="height: 50px; line-height: 50px; font-size: 10px;">&nbsp;</div>
                        </td>
                    </tr>
                    <!--header END--> <!--content 1 -->
                    <tr>
                        <td align="center" bgcolor="#fbfcfd">
                            <table border="0" width="90%" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td align="center">
                                        <div style="line-height: 24px;">
                                            <span
                                                style="font-size: large; color: #57697e; font-family: Arial, Helvetica, sans-serif;">
                                                <span
                                                    style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">
Cher(e) <?= $user->nomcomplet ?>,<br/>
                                                    bienvenue sur notre site <?= $sitename ?>,<br/>
votre login utilisateur est :<br/>
                                                    <?= $user->username ?><br/>
Le mot de passe que vous avez choisi est :<br/>
                                                    <?= $password ?><br/>
                                                    Vous pouvez vous connecter en cliquant sur ce <a
                                                        style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"
                                                        href="<?= $this->Url->build([
                                                                                        'controller' => 'Users',
                                                                                        'action'     => 'login',
                                                                                        'plugin'     => 'UserManager',
                                                                                        '_ssl'       => TRUE], TRUE) ?>"
                                                        target="_blank">lien</a>.<br/>
                                                        A bientôt sur le site <?= $sitename ?> !<br/>
                                                </span>
                                            </span>
                                        </div>
                                        <!-- padding -->
                                        <div style="height: 40px; line-height: 40px; font-size: 10px;">&nbsp;</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <!--footer -->
                    <tr>
                        <td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding -->
                            <div style="height: 80px; line-height: 80px; font-size: 10px;"></div>
                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td align="center"><span
                                            style="font-size: medium; color: #96a5b5; font-family: Arial, Helvetica, sans-serif;"> <span
                                                style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;"> <?= date('Y') ?> &copy;
                                                <?= $sitename ?> Tout droits reserv&eacute;. </span></span></td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- padding -->
                            <div style="height: 30px; line-height: 30px; font-size: 10px;">&nbsp;</div>
                        </td>
                    </tr>
                    <!--footer END-->
                    <tr>
                        <td><!-- padding -->
                            <div style="height: 80px; line-height: 80px; font-size: 10px;">&nbsp;</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- [if gte mso 10]>
                </td></tr>
                </table>
                <![endif]--></td>
        </tr>
        </tbody>
    </table>
</div>
