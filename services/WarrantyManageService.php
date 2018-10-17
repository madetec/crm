<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\Warranty;
use madetec\crm\forms\WarrantyAssignmentForm;
use madetec\crm\forms\WarrantyForm;
use madetec\crm\repositories\WarrantyRepository;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class CategoryManageService
 * @package madetec\crm\services
 * @property WarrantyRepository $warranties
 */
class WarrantyManageService
{
    private $warranties;

    public function __construct(WarrantyRepository $warrantyRepository)
    {
        $this->warranties = $warrantyRepository;
    }

    /**
     * @param WarrantyForm $form
     * @return Warranty
     * @throws \DomainException
     */
    public function create(WarrantyForm $form): Warranty
    {
        $warranty = Warranty::create($form->client_id, $form->expired_at);
        $this->warranties->save($warranty);
        return $warranty;
    }

    /**
     * @param $id
     * @param WarrantyForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit($id, WarrantyForm $form): void
    {
        $warranty = $this->warranties->find($id);
        $warranty->edit($form->client_id, $form->expired_at);
        $this->warranties->save($warranty);
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
        $warranty = $this->warranties->find($id);
        $this->warranties->remove($warranty);
    }

    /**
     * @param $id
     * @param WarrantyAssignmentForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function assign($id, WarrantyAssignmentForm $form): void
    {
        $warranty = $this->warranties->find($id);
        $warranty->assign($form->params);
        $this->warranties->save($warranty);
    }

    /**
     * @param $warranty_id
     * @param $assign_id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function removeAssign($warranty_id, $assign_id)
    {
        $warranty = $this->warranties->find($warranty_id);
        $warranty->revoke($assign_id);
        $this->warranties->save($warranty);
    }
}