<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                                'attribute' => 'photo',
                                'value' => function (\madetec\crm\entities\News $model) {
                                    return Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin'));
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'title',
                                'value' => function (\madetec\crm\entities\News $model) {
                                    return Html::a($model->title, \yii\helpers\Url::to(['/admin/news/view', 'id' => $model->id]));
                                },
                                'format' => 'raw'
                            ],
                            'description',
                            'created_at:datetime',
                            'updated_at:datetime',
                            'published_at:date',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return \madetec\crm\entities\News::statusName($model->status);
                                },
                                'filter' => \madetec\crm\entities\News::statusList(),
                            ],
                            ['class' => 'yii\grid\ActionColumn'],
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
