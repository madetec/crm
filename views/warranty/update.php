<?php

/* @var $this yii\web\View */
/* @var $warranty madetec\crm\entities\Warranty */
/* @var $form madetec\crm\forms\WarrantyForm */

$this->title = 'Редактировать гарантию №: ' . $warranty->id;
$this->params['breadcrumbs'][] = ['label' => 'Звказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $warranty->id, 'url' => ['view', 'id' => $warranty->id]];
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
