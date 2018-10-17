# Madetec ControlPanel

`app/web/index.php`

```
$app = require __DIR__ . '/../config/web.php';

$admin = require __DIR__ . '/../vendor/madetec/crm/config/main.php';

$config = \yii\helpers\ArrayHelper::merge($app, $admin);

(new yii\web\Application($config))->run();
```

`app/config/console.php`

```
'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@vendor/madetec/crm/migrations',
        ]
    ], 
```
console command `php yii migrate`