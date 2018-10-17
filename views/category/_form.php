<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $category madetec\crm\entities\Category */
/* @var $model madetec\crm\forms\CategoryForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="col-md-4">
    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'image')->widget(FileInput::class, [
                'pluginOptions' => [
                    'initialPreview' => isset($category) ? $category->getThumbFileUrl('image') : false,
                    'initialPreviewAsData' => true,
                    'showUpload' => false,
                ],
                'options' => ['accept' => 'image/*']
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

