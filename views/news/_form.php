<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model \madetec\crm\forms\NewsForm */
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
                <?php if ($model->isNewRecord()): ?>
                    <?= $form->field($model->photos, 'files[]')
                        ->label(' Фотографии')
                        ->widget(FileInput::class, [
                            'options' => [
                                'accept' => 'image/*',
                                'multiple' => true,
                            ]
                        ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>
                <?= $form->field($model, 'published_at')->textInput(['maxlength' => true, 'value' => date('d-m-Y')]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>


<?php

$script = <<<JS
$('#newsform-published_at').inputmask({alias:"dd-mm-yyyy", placeholder: "дд-мм-гггг",});
JS;

$this->registerJs($script);

