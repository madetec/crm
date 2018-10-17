<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;

use madetec\crm\entities\Warranty;
use yii\web\NotFoundHttpException;

class WarrantyRepository
{
    /**
     * @param $id
     * @return Warranty
     * @throws NotFoundHttpException
     */
    public function find($id): Warranty
    {
        if(!$warranty = Warranty::findOne($id))
        {
            throw new NotFoundHttpException('Warranty not found');
        }
        return $warranty;
    }

    /**
     * @param Warranty $warranty
     * @return Warranty
     * @throws \DomainException
     */
    public function save(Warranty $warranty): Warranty
    {
        if(!$warranty->save())
        {
            throw new \DomainException('Warranty save error');
        }
        return $warranty;
    }

    /**
     * @param Warranty $warranty
     * @return Warranty
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Warranty $warranty): Warranty
    {
        if(!$warranty->delete())
        {
            throw new \DomainException('Warranty remove error');
        }
        return $warranty;
    }
}