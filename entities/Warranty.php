<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

/**
 * @property integer $id
 * @property integer $client_id
 * @property integer $expired_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property Client $client
 * @property WarrantyAssignment[] $assignments
 */
class Warranty extends ActiveRecord
{

    public static function create($client_id, $expired_at)
    {
        $warranty = new static();
        $warranty->expired_at = $expired_at;
        $warranty->client_id = $client_id;
        $warranty->created_at = time();
        $warranty->updated_at = time();
        return $warranty;
    }

    public function edit($client_id, $expired_at)
    {
        $this->expired_at = $expired_at;
        $this->client_id = $client_id;
        $this->updated_at = time();
    }

    public function assign($params)
    {
        $assignments = $this->assignments;
        $assignments[] = WarrantyAssignment::create($params);
        $this->assignments = $assignments;

    }

    public function revoke($id)
    {
        $assignments = $this->assignments;
        foreach ($assignments as $k => $assignment) {
            if ($assignment->isEqualId($id)) {
                unset($assignments[$k]);
                $this->assignments = $assignments;
                return;
            }
        }
    }


    /**
     * @return int
     * @throws \DomainException
     */

    public function leftUntilTheWarrantyEnds(): int
    {
        if ($this->isExpiredWarranty()) {
            throw new \DomainException('Warranty expired');
        }

        return (strtotime($this->expired_at) - time()) / 3600 / 24;
    }

    public function isExpiredWarranty(): bool
    {
        return strtotime($this->expired_at) < time();
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getAssignments(): ActiveQuery
    {
        return $this->hasMany(WarrantyAssignment::class, ['warranty_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['assignments'],
            ]
        ];
    }

    /**
     * @throws \yii\base\InvalidArgumentException
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->expired_at = \Yii::$app->formatter->asDate($this->expired_at, 'php:Y-m-d');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->expired_at = strtotime($this->expired_at);
            return true;
        }
        return false;
    }


    public static function tableName()
    {
        return '{{%warranties}}';
    }

    public function attributeLabels()
    {
        return [
            'client_id' => 'Клиент',
            'expired_at' => 'Дата окончания гарантии',
            'created_at' => 'Дата добавления',
        ];
    }
}