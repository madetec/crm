<?php


/* @var $this yii\web\View */
/* @var $model madetec\crm\entities\Order */

$this->title = 'Добавление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
