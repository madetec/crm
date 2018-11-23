<?php

use madetec\crm\entities\Client;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model madetec\crm\forms\ClientForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $client Client */

?>
<?php $form = ActiveForm::begin(); ?>
    <div class="col-md-8">
        <div class="box">
            <div class="box-body">

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address_line_1')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address_line_2')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'date_of_birth')->textInput() ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'status')->dropDownList(
                    [
                        Client::STATUS_CLIENT => 'Клиент',
                        Client::STATUS_DEALER => 'Диллер'
                    ]
                ) ?>
                <?= $form->field($model, 'avatar')->widget(FileInput::class, [
                    'pluginOptions' => [
                        'initialPreview' => isset($client) ? $client->getThumbFileUrl('avatar') : false,
                        'initialPreviewAsData'=>true,
                        'showUpload' => false,
                    ],
                    'options' => ['accept' => 'image/*']
                ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>


<?php

$script = <<<JS
$('#clientform-phone').inputmask("+998 (99) 999-99-99");
$('#clientform-date_of_birth').inputmask({alias:"yyyy-mm-dd", placeholder: "гггг-мм-дд",});
JS;

$this->registerJs($script);

