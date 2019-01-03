<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $directoryAsset string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">'. substr(Yii::$app->name,0,2) .'</span><span class="logo-lg">' . Yii::$app->name . '</span>', '/admin', ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= Url::to(['/images/avatars/common-avatar.jpg']) ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">Administrator</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Url::to(['/images/avatars/common-avatar.jpg']) ?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                Administrator
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="align-center">
                                <?= Html::a(
                                    Html::tag('i',null,['class' => 'fa fa-shield']). ' Поменять пароль',
                                    ['/admin/default/change-password'],
                                    ['class' => 'btn btn-default btn-flat btn-block']
                                ) ?>

                                <?= Html::a(
                                    'Выход',
                                    ['/admin/auth/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-info btn-flat btn-block']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
