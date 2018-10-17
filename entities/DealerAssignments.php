<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;


use yii\db\ActiveRecord;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class DealerAssignments
 * @package madetec\crm\entities
 * @property integer $client_id
 * @property integer $dealer_id
 * @property float $percent
 */
class DealerAssignments extends ActiveRecord
{
    public static function create($dealer_id = null, $client_id = null): self
    {
        $assignment = new static();
        $assignment->dealer_id = $dealer_id;
        $assignment->client_id = $client_id;
        return $assignment;
    }

    public function edit($dealer_id = null, $client_id = null)
    {
        $this->dealer_id = $dealer_id;
        $this->client_id = $client_id;
    }

    public function isClientId($id)
    {
        return $this->client_id == $id;
    }

    public function isDealerId($id)
    {
        return $this->dealer_id == $id;
    }

    public static function tableName()
    {
        return '{{%dealer_assignments}}';
    }
}