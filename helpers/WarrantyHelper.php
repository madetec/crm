<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\helpers;


use madetec\crm\entities\Warranty;
use yii\helpers\Html;

class WarrantyHelper
{
    public static function getExpiredLabel(Warranty $warranty)
    {
        if ($warranty->isExpiredWarranty()) {
            return Html::tag('span', 'Гарантия истекло', ['class' => 'label label-default']);
        }

        return Html::tag('span', 'На гарантии', ['class' => 'label label-success']);
    }

    public static function getRestLabel(Warranty $warranty)
    {
        try {
            return Html::tag('span', self::convertDayHuman($warranty->leftUntilTheWarrantyEnds()), ['class' => 'label label-success']);
        } catch (\DomainException $e) {
            return Html::tag('span', 'Гарантия истекло', ['class' => 'label label-default']);
        }
    }


    protected static function convertDayHuman($a)
    {
        $x = $a % 100;
        $y = ($x % 10) - 1;
        $day =  ($x / 10) >> 0 == 1 ? 'дней' : ($y & 12 ? 'дней' : ($y & 3 ? 'дня' : 'день'));
        return $a . ' ' . $day;
    }
}