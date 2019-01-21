<?php

use madetec\crm\entities\Client;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $news madetec\crm\entities\News */

$this->title = 'Информация';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box">
                <div class="box-header">
                    <?= Html::a('Редактировать', ['update', 'id' => $news->id], ['class' => 'btn btn-flat btn-primary']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $news->id], [
                        'class' => 'btn btn-danger btn-flat',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
                <div class="box-body">
                    <div class="media">
                        <div class="media-body">
                            <h4><?= $news->title ?></h4>
                        </div>
                    </div>

                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td><?= $news->id ?></td>
                        </tr>
                        <tr>
                            <th>Заголовок</th>
                            <td><?= $news->title ?></td>

                        </tr>
                        <tr>
                            <th>Описание</th>
                            <td><?= $news->description ?></td>
                        </tr>
                        <tr>
                            <th>Текст</th>
                            <td><?= $news->text ?></td>
                        </tr>
                        <tr>
                            <th>Дата создание</th>
                            <td><?= Yii::$app->formatter->asDatetime($news->created_at) ?></td>
                        </tr>
                        <tr>
                            <th>Дата обновление</th>
                            <td><?= Yii::$app->formatter->asDatetime($news->updated_at) ?></td>
                        </tr>
                        <tr>
                            <th>Дата публикаций</th>
                            <td><?= Yii::$app->formatter->asDate($news->published_at) ?></td>
                        </tr>
                        <tr>
                            <th>Статус</th>
                            <td><?= $news::statusName($news->status) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box" id="photos">
            <div class="box-header with-border">Фотографии</div>
            <div class="box-body">

                <div class="row">
                    <?php foreach ($news->photos as $photo): ?>
                        <div class="col-md-2 col-xs-3" style="text-align: center">
                            <div class="btn-group">
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $news->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]); ?>
                                <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $news->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Remove photo?',
                                ]); ?>
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $news->id, 'photo_id' => $photo->id], [
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

                <?= $form->field($photosForm, 'files[]')->label(false)->widget(\kartik\file\FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ]
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
