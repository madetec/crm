<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $discount madetec\crm\entities\Discount */
/* @var $model madetec\crm\forms\ChangePasswordForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Новый пароль';
?>
<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-8">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
