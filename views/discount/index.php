<?php

use yii\grid\GridView;
use yii\helpers\Html;
use madetec\crm\entities\Category;

/* @var $this yii\web\View */
/* @var $searchModel madetec\crm\search\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Добавить акцию', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
            </div>
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                                'value' => function(\madetec\crm\entities\Discount $model){
                                    return Html::img($model->getThumbFileUrl('photo','admin'),['class' => 'img-circle']);
                                },
                                'format' => 'raw',
                                'filter' => false
                        ],
                        'title',
                        'description',
                        [
                            'label' => 'Состояние гарантии',
                            'value' => function (\madetec\crm\entities\Discount $model) {
                                return \madetec\crm\helpers\DiscountHelpers::getStatusLabel($model->status);
                            },
                            'format' => 'raw',
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
</div>
