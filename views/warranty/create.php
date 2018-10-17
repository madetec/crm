<?php


/* @var $this yii\web\View */
/* @var $model madetec\crm\entities\Warranty */

$this->title = 'Добавление гарантии';
$this->params['breadcrumbs'][] = ['label' => 'Гарантии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
