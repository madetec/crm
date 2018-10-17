<?php

use madetec\crm\helpers\OrderHelper;
use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $order madetec\crm\entities\Order */

$this->title = 'Заказ № ' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$btnNew = Html::a('Новый', ['status-new', 'id' => $order->id], ['class' => 'btn btn-flat btn-info', 'data-method' => 'post']);
$btnSold = Html::a('Продан', ['status-sold', 'id' => $order->id], ['class' => 'btn btn-flat btn-success', 'data-method' => 'post']);
$btnCanceled = Html::a(Html::tag('i','',['class'=>'fa fa-remove']).' Отменен', ['status-canceled', 'id' => $order->id], ['class' => 'pull-right btn btn-flat btn-default', 'data-method' => 'post']);
$productLinks = [];
foreach ($order->products as $product) {
    $productLinks[] = OrderHelper::getProductLink($product);
}

?>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Редактировать', ['update', 'id' => $order->id], ['class' => 'btn btn-flat btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $order->id], [
                    'class' => 'btn btn-flat btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <div class="box-body">
                <?php try {
                    echo DetailView::widget([
                        'model' => $order,
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'value' => Html::a('Заказ № ' . $order->id, ['view', 'id' => $order->id]),
                                'format' => 'raw',
                            ],
                            ['attribute' => 'products',
                                'value' => implode('<br/>', $productLinks),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'client_id',
                                'value' => OrderHelper::getClientLink($order->client),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'status',
                                'value' => OrderHelper::statusLabel($order->status),
                                'format' => 'raw',
                            ],
                            'created_at:datetime',
                        ],
                    ]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                } ?>
            </div>
            <div class="box-footer">
                <h4>Управление статусом товара</h4>
                <?php if ($order->isNew()){
                    echo $btnSold . $btnCanceled;
                }elseif($order->isSold()){
                    echo $btnNew . $btnCanceled;
                }elseif($order->isCanceled()){
                    echo $btnNew . $btnSold;
                } ?>
            </div>
        </div>
    </div>
</div>