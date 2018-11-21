<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model madetec\crm\entities\Discount */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Акции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])?>


                </div>

            <div class="box-body">
                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#">
                            <?= Html::img($model->getThumbFileUrl(
                                'photo',
                                'admin',
                                \Yii::getAlias('@noAvatar')),
                                [
                                    'class' => 'img-circle media-object',
                                    'style' => 'max-width: 50px;'
                                ]
                            ) ?>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4><?= $model->title ?></h4>
                        <p><?= $model->description ?></p>
                        <p><?= \madetec\crm\helpers\DiscountHelpers::getStatusLabel($model->status) ?></p>
                    </div>
                </div>

                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td><?= $model->id ?></td>
                    </tr>
                    <tr>
                        <th>Наименование</th>
                        <td><?= $model->title ?></td>
                    </tr>
                    <tr>
                        <th>Описание</th>
                        <td><?= $model->description ?></td>
                    </tr>
                    <tr>
                        <th>Текст</th>
                        <td><?= Html::decode($model->text) ?></td>
                    </tr>
                    <tr>
                        <th>Дата начала акции</th>
                        <td><?= Yii::$app->formatter->asDate($model->published_at,'php:d-m-Y') ?></td>
                    </tr>
                    <tr>
                        <th>Дата окончания акции</th>
                        <td><?= Yii::$app->formatter->asDate($model->expired_at,'php:d-m-Y') ?></td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <?php if($model->status != \madetec\crm\entities\Discount::STATUS_ACTIVATED): ?>
                    <?= Html::a('Активный', ['activated', 'id' => $model->id], ['class' => 'btn btn-flat btn-success', 'data-method' => 'post']); ?>
                <?php else: ?>
                    <?= Html::a('Черновик', ['draft', 'id' => $model->id], ['class' => 'btn pull-right btn-flat btn-default', 'data-method' => 'post']); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
