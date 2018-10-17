<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * @var $categories \madetec\crm\entities\Category[]
 */
use yii\helpers\Html;
?>

<div class="row bottom tags-wrap">
    <div class="col-full tags">
        <h3>часто ищут</h3>

        <div class="tagcloud">
            <?php foreach ($categories as $category): ?>
                <?= Html::a($category->name,['products/category','slug' => $category->slug]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
