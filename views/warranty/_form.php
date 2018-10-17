<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model madetec\crm\forms\WarrantyForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_id')->dropDownList($model->getClientList(), ['prompt' => 'Выберите ...']) ?>

    <?= $form->field($model, 'expired_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php

$script = <<<JS
$('#warrantyform-expired_at').inputmask({alias:"yyyy-mm-dd", placeholder: "гггг-мм-дд",});
JS;

$this->registerJs($script);