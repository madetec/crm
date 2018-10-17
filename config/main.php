<?php
$config = [
    'aliases' => [
        // setting admin panel
        '@uploads' => '@app/web/uploads',
        '@uploadsUrl' => '/uploads',
        '@noAvatar' => '/uploads/no-avatar.jpg',
    ],

    'modules' => [
        'admin' => [
            'class' => \madetec\crm\Module::class,
            'viewPath' => '@vendor/madetec/crm/views',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'except' => ['auth/login', 'auth/error', 'auth/captcha'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ],
    ],

    'components' => [
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
            ],
        ],
        'user' => [
            'identityClass' => madetec\crm\entities\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/auth/login'],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // setting admin panel

                'admin' => 'admin/default/index',
                'admin/<_c:[\w\-]+>' => 'admin/<_c>/index',
                'admin/<_c:[\w\-]+>/<id:\d+>' => 'admin/<_c>/view',
                'admin/<_c:[\w\-]+>/<_a:[\w-]+>' => 'admin/<_c>/<_a>',

                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<slug:[\w\-]+>' => '<_c>/category',
                '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ],
        ],
    ],


];

return $config;
