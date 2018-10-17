<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * @var $products \madetec\crm\entities\Product[]
 */

use yii\helpers\Html;

?>
<?php foreach ($products as $product): ?>
    <article class="col-block popular__post">
        <?= Html::a(Html::img($product->mainPhoto ? $product->mainPhoto->getThumbFileUrl('file', 'small') : null), ['products/view', 'id' => $product->id], ['class' => 'popular__thumb']) ?>
        <h5><?= Html::a($product->name, ['products/view', 'id' => $product->id]) ?></h5>
        <section class="popular__meta">
            <span class="popular__author"> <b>от <?= Yii::$app->formatter->asCurrency($product->price) ?></b></span>
        </section>
    </article>
<?php endforeach; ?>
