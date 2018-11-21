<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $form madetec\crm\entities\Category */

$this->title = 'Добавить акцию';
$this->params['breadcrumbs'][] = ['label' => 'Акции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>
</div>
