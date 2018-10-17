<?php

use madetec\crm\helpers\OrderHelper;
use madetec\crm\helpers\WarrantyHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $warranty madetec\crm\entities\Warranty */
/* @var $warrantyAssignmentForm madetec\crm\forms\WarrantyAssignmentForm */

$this->title = 'Гарантия № ' . $warranty->id;
$this->params['breadcrumbs'][] = ['label' => 'Гарантии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Редактировать', ['update', 'id' => $warranty->id], ['class' => 'btn btn-flat btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $warranty->id], [
                    'class' => 'btn btn-flat btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <div class="box-body">
                <h4><b>Общая информация</b></h4>
                <?php try {
                    echo DetailView::widget([
                        'model' => $warranty,
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'value' => Html::a('Гарантия № ' . $warranty->id, ['view', 'id' => $warranty->id]),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'client_id',
                                'value' => OrderHelper::getClientLink($warranty->client),
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Состояние гарантии',
                                'value' => WarrantyHelper::getExpiredLabel($warranty),
                                'format' => 'raw',
                            ],
                            'created_at:datetime',
                        ],
                    ]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                } ?>
            </div>
            <div class="box-footer">
                <h4><b>Проверка по гарантии</b></h4>
                <?php if ($warranty->assignments): ?>
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Дата последней проверки</th>
                                <th>описание</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($warranty->assignments as $assignment): ?>
                                <tr>
                                    <td><?= \Yii::$app->formatter->asDate($assignment->created_at) ?></td>
                                    <td><?= $assignment->params ?></td>
                                    <td><?= Html::a(Html::tag('i', '', ['class' => 'fa fa-remove']), ['remove-assign', 'warranty_id' => $warranty->id, 'assign_id' => $assignment->id]) ?></td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <hr>
                <?php endif; ?>
                <?php $form = \yii\widgets\ActiveForm::begin(); ?>

                <?= $form->field($warrantyAssignmentForm, 'params')->textarea() ?>

                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>