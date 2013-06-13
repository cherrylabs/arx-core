<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="fr" dir="ltr" ng-app><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="fr" dir="ltr" ng-app><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="fr" dir="ltr" ng-app><![endif]-->
<!--[if IE 8]><html class="ie8" lang="fr" dir="ltr" ng-app><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="<?= Arx\c_config::get('lang') or 'en'; ?>" dir="ltr" ng-app>
<!--<![endif]-->
<head>
<?= $this->fetch('head') ?>
</head>
<body <?= u::issetOr('this->_body->attr') ?>>
		
		<?= $this->fetch('header') ?>

        <?php
            // write from controller $this->content()
            echo u::issetOr('this->content', $this->fetch('content'));
        ?>

<?php echo $this->fetch('footer') ?>
</body>
</html>