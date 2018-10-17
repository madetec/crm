<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model madetec\crm\forms\OrderForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'client')->dropDownList($model->getClientList(), ['prompt' => 'Выберите ...']) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusList(), ['prompt' => 'Выберите ...']) ?>
    <div class="row" id="product-row">
        <?php foreach ($model->products as $k => $product): ?>
            <div class="cols">
                <div class="col-md-7">
                    <?= $form->field($product, '[' . $k . ']product')->dropDownList($product->getProductList(), ['prompt' => 'Выберите товар'])->label(false) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($product, '[' . $k . ']quantity')->textInput(['type' => 'number'])->label(false) ?>
                </div>
                <div class="col-md-1">
                    <?= Html::tag('i', '', ['class' => 'fa fa-plus', 'style' => 'line-height: 35px; cursor: pointer;']) ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$script = <<<JS
$( document ).ready(function() {
    var i = 0;
    var cols = $('.cols');
    var colsLast = cols.last().html();
    var row = $('#product-row');
    var btnPlus = $('.fa-plus');
    var btnPlusLast = btnPlus.last();
    
    btnPlus.addClass('fa-minus');
    btnPlus.removeClass('fa-plus');
    
    btnPlusLast.removeClass('fa-minus');
    btnPlusLast.addClass('fa-plus');
    
    row.on('click','.fa-plus',function(){
        row.append('<div class="cols">'+colsLast+'</div>');
        i++;
        var input = $('.cols').last().find('input[name="OrderProductsForm[0][quantity]"]');
        var select = $('.cols').last().find('select[name="OrderProductsForm[0][product]"]');
        input.attr('name','OrderProductsForm['+i+'][quantity]');
        select.attr('name','OrderProductsForm['+i+'][product]');
        $(this).removeClass('fa-plus');
        $(this).addClass('fa-minus');
       
    });
    
    row.on('click','.fa-minus',function(){
        $(this).parent().parent().remove();
    });
})


JS;


$this->registerJs($script);