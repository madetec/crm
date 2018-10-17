<?php

use madetec\crm\helpers\ProductHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $product madetec\crm\entities\Product */
/* @var $photosForm madetec\crm\forms\PhotosForm */

$this->title = 'Информация';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box">
                <div class="box-header">
                    <?php if ($product->isActive()): ?>
                        <?= Html::a('Черновик', ['draft', 'id' => $product->id], ['class' => 'btn btn-flat btn-primary', 'data-method' => 'post']) ?>
                    <?php else: ?>
                        <?= Html::a('Активный', ['activate', 'id' => $product->id], ['class' => 'btn btn-flat btn-success', 'data-method' => 'post']) ?>
                    <?php endif; ?>
                    <?= Html::a('Редактировать', ['update', 'id' => $product->id], ['class' => 'btn btn-flat btn-primary']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $product->id], [
                        'class' => 'btn btn-danger btn-flat',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            [
                                'attribute' => 'mainPhoto',
                                'value' => $product->mainPhoto ? Html::img($product->mainPhoto->getThumbFileUrl('file', 'admin')) : null,
                                'format' => 'raw'
                            ],
                            'id',
                            [
                                'attribute' => 'status',
                                'value' => ProductHelper::statusLabel($product->status),
                                'format' => 'raw',
                            ],
                            'article',
                            'name',
                            [
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($product, 'category.name'),
                            ],
                            [
                                'label' => 'Other categories',
                                'value' => implode(', ', ArrayHelper::getColumn($product->categories, 'name')),
                            ],
                            'quantity',
                            [
                                'attribute' => 'price',
                                'value' => Yii::$app->formatter->asCurrency($product->price),
                            ],
                            [
                                'attribute' => 'old_price',
                                'value' => Yii::$app->formatter->asCurrency($product->old_price),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box" id="photos">
            <div class="box-header with-border">Фотографии</div>
            <div class="box-body">

                <div class="row">
                    <?php foreach ($product->photos as $photo): ?>
                        <div class="col-md-2 col-xs-3" style="text-align: center">
                            <div class="btn-group">
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]); ?>
                                <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Remove photo?',
                                ]); ?>
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]); ?>
                            </div>
                            <div>
                                <?= Html::a(
                                    Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                    $photo->getUploadedFileUrl('file'),
                                    ['class' => 'thumbnail', 'target' => '_blank']
                                ) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php $form = ActiveForm::begin([
                    'options' => ['enctype'=>'multipart/form-data'],
                ]); ?>

                <?= $form->field($photosForm, 'files[]')->label(false)->widget(FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ]
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
