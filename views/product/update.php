<?php

use yii\helpers\Html;
use madetec\crm\entities\Client;

/* @var $this yii\web\View */
/* @var Client $client */

$this->title = 'Редактировать клиента: ' . $client->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $client->name, 'url' => ['view', 'id' => $client->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="row">

    <?= $this->render('_form', [
        'model' => $form,
        'client' => $client,
    ]) ?>

</div>
