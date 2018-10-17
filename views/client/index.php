<?php

use madetec\crm\entities\Client;
use madetec\crm\helpers\ClientHelpers;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel madetec\crm\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                                'value' => function (Client $model) {
                                    return Html::img(
                                        $model->getThumbFileUrl(
                                            'avatar',
                                            'admin',
                                            Yii::getAlias('@noAvatar')
                                        ),
                                        [
                                            'class' => 'img-circle',
                                            'style' => 'max-width: 50px;'
                                        ]
                                    );
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Client $model) {
                                    return Html::a(
                                        $model->name . ' ' . $model->last_name,
                                        Url::to(
                                            [
                                                '/admin/client/view',
                                                'id' => $model->id
                                            ]
                                        )
                                    );
                                },
                                'format' => 'raw'
                            ],
                            'phone',
                            'email:email',
                            'address_line_1',
                            [
                                'attribute' => 'status',
                                'value' => function (Client $model) {
                                    return ClientHelpers::getStatusLabel($model->status);
                                },
                                'format' => 'raw'
                            ]
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
