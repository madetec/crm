<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $warranty_id
 * @property integer $created_at
 * @property string $params
 */
class WarrantyAssignment extends ActiveRecord
{

    public static function create($params)
    {
        $assignment = new static();
        $assignment->params = $params;
        $assignment->created_at = time();
        return $assignment;
    }

    public function edit($params)
    {
        $this->params = $params;
    }

    public function isEqualId($id)
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%warranty_assignments}}';
    }

    public function attributeLabels()
    {
        return [
            'params' => 'Описание',
            'created_at' => 'Дата добавления',
        ];
    }
}