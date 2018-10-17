<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;


use madetec\crm\entities\Client;
use yii\web\NotFoundHttpException;

class ClientRepository
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

    /**
     * @param Client $client
     * @return Client
     * @throws \DomainException
     */
    public function save(Client $client): Client
    {
        if(!$client->save())
        {
            throw new \DomainException('Client save error');
        }
        return $client;
    }

    /**
     * @param Client $client
     * @return Client
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Client $client): Client
    {
        if(!$client->delete())
        {
            throw new \DomainException('Client remove error');
        }
        return $client;
    }
}