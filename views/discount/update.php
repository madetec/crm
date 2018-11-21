<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $discount madetec\crm\entities\Discount */
/* @var $form madetec\crm\forms\DiscountForm */

$this->title = 'Редактировать акцию: ' . $discount->title;
$this->params['breadcrumbs'][] = ['label' => 'акции', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $discount->title, 'url' => ['view', 'id' => $discount->id]];
$this->params['breadcrumbs'][] = 'редактировать';
?>
<div class="row">

    <?= $this->render('_form', [
        'model' => $form,
        'discount' => $discount,
    ]) ?>

</div>
