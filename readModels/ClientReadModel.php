<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\readModels;


use madetec\crm\entities\Client;
use yii\web\NotFoundHttpException;

class ClientReadModel
{
    /**
     * @param $id
     * @return Client
     * @throws NotFoundHttpException
     */
    public function find($id): Client
    {
        if(!$client = Client::findOne($id))
        {
            throw new NotFoundHttpException('Client not found');
        }
        return $client;
    }
}