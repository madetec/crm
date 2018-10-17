<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $category madetec\crm\entities\Category */
/* @var $form madetec\crm\forms\CategoryForm */

$this->title = 'Update Category: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">

    <?= $this->render('_form', [
        'model' => $form,
        'category' => $category,
    ]) ?>

</div>
