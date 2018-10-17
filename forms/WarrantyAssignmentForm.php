<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;

use madetec\crm\entities\Client;
use madetec\crm\entities\Warranty;
use madetec\crm\entities\WarrantyAssignment;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property integer $params
 */
class WarrantyAssignmentForm extends Model
{
    public $params;

    public function __construct(WarrantyAssignment $assignment = null, array $config = [])
    {
        if ($assignment) {
            $this->params = $assignment->params;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['params'], 'string'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'params' => 'Описание',
            'created_at' => 'Дата добавления',
        ];
    }
}