<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $discount madetec\crm\entities\Discount */
/* @var $model madetec\crm\forms\DiscountForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="col-md-8">
    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'text')->widget(\vova07\imperavi\Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'imageUpload' => Url::to(['discount/image-upload']),
                    'imageManagerJson' => Url::to(['discount/images-get']),
                    'plugins' => [
                        'imagemanager',
                        'fullscreen',
                    ],
                    'clips' => [
                        ['Lorem ipsum...', 'Lorem...'],
                        ['red', '<span class="label-red">red</span>'],
                        ['green', '<span class="label-green">green</span>'],
                        ['blue', '<span class="label-blue">blue</span>'],
                    ],
                ],
            ]); ?>


        </div>
    </div>
</div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>
                <?= $form->field($model, 'published_at')->textInput() ?>
                <?= $form->field($model, 'expired_at')->textInput() ?>

                <?= $form->field($model, 'photo')->widget(FileInput::class, [
                    'pluginOptions' => [
                        'initialPreview' => isset($discount) ? $discount->getThumbFileUrl('photo','small') : false,
                        'initialPreviewAsData' => true,
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
$('#discountform-published_at').inputmask({alias:"dd-mm-yyyy", placeholder: "дд-мм-гггг",});
$('#discountform-expired_at').inputmask({alias:"dd-mm-yyyy", placeholder: "дд-мм-гггг",});
JS;

$this->registerJs($script);

