<?php

/* @var $this yii\web\View */
/* @var $order madetec\crm\entities\Order */
/* @var $form madetec\crm\forms\OrderForm */

$this->title = 'Редактировать заказ №: ' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Звказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $order->id, 'url' => ['view', 'id' => $order->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-body">
                <?php try {
                    echo $this->render('_form', [
                        'model' => $form,
                    ]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                } ?>
            </div>
        </div>
    </div>
</div>
