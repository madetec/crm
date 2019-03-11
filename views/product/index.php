<?php

use madetec\crm\entities\Product;
use madetec\crm\helpers\ProductHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel madetec\crm\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
            </div>
            <div class="box-body">
                <?php
                try {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'value' => function (Product $model) {
                                    return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 100px'],
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Product $model) {
                                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                    'attribute' => 'price',
                                    'value' => function($model)
                                    {
                                        return \Yii::$app->formatter->asCurrency($model->price, "som");
                                    },
                                    'format' => 'raw'
                            ],
                            [
                                    'attribute' => 'old_price',
                                    'value' => function($model)
                                    {
                                        return \Yii::$app->formatter->asCurrency($model->price, "som");
                                    },
                                    'format' => 'raw'
                            ],
                            'quantity',
                            'article',
                            [
                                'attribute' => 'category_id',
                                'value' => function (Product $model) {
                                    return Html::a($model->category->name, ['category/view', 'id' => $model->id]);
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'status',
                                'value' => function (Product $model) {
                                    return ProductHelper::statusLabel($model->status);
                                },
                                'format' => 'raw',
                            ],

                        ],
                    ]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                ?>
            </div>
        </div>
    </div>
</div>
