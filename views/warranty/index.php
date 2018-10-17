<?php

use madetec\crm\entities\Warranty;
use madetec\crm\helpers\WarrantyHelper;
use madetec\crm\helpers\OrderHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel madetec\crm\search\WarrantySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Гарантии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Оформить гарантию', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <div class="box-body">
                <?php try {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Состояние гарантии',
                                'value' => function (Warranty $warranty) {
                                    return WarrantyHelper::getExpiredLabel($warranty);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Осталось дней',
                                'value' => function (Warranty $warranty) {
                                    return WarrantyHelper::getRestLabel($warranty);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'id',
                                'value' => function (Warranty $Warranty) {
                                    return Html::a('Гарантия № ' . $Warranty->id, ['view', 'id' => $Warranty->id]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'client_id',
                                'value' => function (Warranty $warranty) {
                                    return OrderHelper::getClientLink($warranty->client);
                                },
                                'format' => 'raw',
                            ],
                            'expired_at:date',
                            'created_at:date',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                } ?>
            </div>
        </div>
    </div>
</div>
