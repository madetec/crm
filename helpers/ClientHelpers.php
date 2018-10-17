<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\helpers;


use madetec\crm\entities\Client;
use yii\helpers\Html;

class ClientHelpers
{
    public static function getStatusLabel($status)
    {
        switch ($status){
            case Client::STATUS_DEALER:
                return Html::tag('span','Диллер',['class' => 'label label-primary']);
            case Client::STATUS_CLIENT:
                return Html::tag('span','Клиент',['class' => 'label label-success']);
        }
    }
}