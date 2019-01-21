<?php

/** @var $news \madetec\crm\entities\News */
/** @var $form \madetec\crm\forms\NewsForm */

$this->title = 'Редактировать новость: ' . $news->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $news->title, 'url' => ['view', 'id' => $news->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="row">

    <?= $this->render('_form', [
        'model' => $form,
        'news' => $news,
    ]) ?>

</div>
