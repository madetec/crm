<?php

use madetec\crm\entities\Product;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model madetec\crm\forms\ProductForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $product Product */

?>
<?php $form = ActiveForm::begin(); ?>
<div class="col-md-8">
    <div class="box">
        <div class="box-body">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'old_price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'params')->textarea() ?>

            <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->photos, 'files[]')
                ->label(' Фотографии')
                ->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>


        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="box">
        <div class="box-body">
            <div class="form-group">
                <?= $form->field($model->categories, 'main')
                    ->label('Категория')
                    ->dropDownList($model->categories->categoriesList(), ['prompt' => '']) ?>
                <?= $form->field($model->categories, 'others')
                    ->label('Сопутствующие категорий')
                    ->checkboxList($model->categories->categoriesList()) ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat btn-block']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


