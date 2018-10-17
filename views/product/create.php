<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model madetec\crm\entities\Product */

$this->title = 'Добавить клиента';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>

</div>
