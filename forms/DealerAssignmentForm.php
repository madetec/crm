<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;


use madetec\crm\entities\Client;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DealerAssignmentForm extends Model
{
    public $clients;
    public $dealer;

    public function __construct(Client $client = null, array $config = [])
    {
        if($client)
        {
            $this->clients = $client->clients;
            $this->dealer = $client->dealer;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        $clientIds = ArrayHelper::getColumn(
            Client::find()
                ->select('id')
                ->where(['status' => Client::STATUS_CLIENT])
                ->asArray()
                ->all(),
            'id');
        $dealerIds = ArrayHelper::getColumn(
            Client::find()
                ->select('id')
                ->where(['status' => Client::STATUS_DEALER])
                ->asArray()
                ->all(),
            'id');

        return [
            ['clients' , 'each', 'rule' => ['in', 'range' => $clientIds]],
            ['dealer', 'in', 'range' => $dealerIds]
        ];
    }
}