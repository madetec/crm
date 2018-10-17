<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\Client;
use madetec\crm\forms\ClientForm;
use madetec\crm\forms\DealerAssignmentForm;
use madetec\crm\repositories\ClientRepository;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class ClientManageService
 * @package madetec\crm\services
 * @property ClientRepository $clients
 */
class ClientManageService
{
    public $clients;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clients = $clientRepository;
    }

    /**
     * @param ClientForm $form
     * @return Client
     * @throws \DomainException
     */
    public function create(ClientForm $form): Client
    {
        $client = Client::create(
            $form->name,
            $form->last_name,
            $form->address_line_1,
            $form->address_line_2,
            $form->date_of_birth,
            $form->phone,
            $form->email,
            $form->params,
            $form->avatar,
            $form->status
        );

        $this->clients->save($client);

        return $client;
    }

    /**
     * @param $id
     * @param ClientForm $form
     * @return Client
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit($id, ClientForm $form): Client
    {
        $client = $this->clients->find($id);
        $client->edit(
            $form->name,
            $form->last_name,
            $form->address_line_1,
            $form->address_line_2,
            $form->date_of_birth,
            $form->phone,
            $form->email,
            $form->params,
            $form->avatar,
            $form->status
        );

        $this->clients->save($client);

        return $client;
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function remove($id): void
    {
        $client = $this->clients->find($id);
        $this->clients->remove($client);
    }

    /**
     * @param $id
     * @param DealerAssignmentForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function assign($id, DealerAssignmentForm $form)
    {
        $client = $this->clients->find($id);
        if ($client->isDealer()) {
            $client->clientAssignments = [];
            $this->clients->save($client);
            foreach ($form->clients as $clientId) {
                if (empty($clientId)) continue;
                $client->assignClient($clientId);
            }
        }

        if ($client->isClient()) {
            $client->dealerAssignments = [];
            $this->clients->save($client);
            if (empty($form->dealer)) return;
            $client->assignDealer($form->dealer);
        }

        $this->clients->save($client);

    }
}