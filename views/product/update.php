<?php

use yii\helpers\Html;
use madetec\crm\entities\Client;

/* @var $this yii\web\View */
/* @var \madetec\crm\entities\Product $product */

$this->title = 'Редактировать товар: ' . $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="row">

    <?= $this->render('_form', [
        'model' => $form,
        'product' => $product,
    ]) ?>

</div>
