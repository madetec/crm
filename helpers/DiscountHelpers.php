<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\helpers;


use madetec\crm\entities\Discount;
use yii\helpers\Html;

class DiscountHelpers
{
    public static function getStatusLabel($status)
    {
        switch ($status){
            case Discount::STATUS_ACTIVATED:
                return Html::tag('span','Активный',['class' => 'label label-success']);
            case Discount::STATUS_EXPIRED:
                return Html::tag('span','Закончин',['class' => 'label label-danger']);
            case Discount::STATUS_DRAFT:
                return Html::tag('span','Черновик',['class' => 'label label-default']);
        }
    }
}