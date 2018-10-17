<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;

use madetec\crm\entities\Client;
use madetec\crm\entities\Warranty;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property integer $client_id
 * @property integer $expired_at
 */
class WarrantyForm extends Model
{
    public $client_id;
    public $expired_at;

    public function __construct(Warranty $warranty = null, array $config = [])
    {
        if ($warranty) {
            $this->client_id = $warranty->client_id;
            $this->expired_at = $warranty->expired_at;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['client_id', 'expired_at'], 'required'],
            [['client_id'], 'integer'],
            [['expired_at'], 'date', 'format' => 'php:Y-m-d'],
            ['client_id', 'exist', 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    public function getClientList(): array
    {
        return ArrayHelper::map(Client::find()->asArray()->all(), 'id', 'name');
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'expired_at' => 'Дата окончания гарантии',
        ];
    }
}