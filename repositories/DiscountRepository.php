<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;


use madetec\crm\entities\Discount;
use yii\web\NotFoundHttpException;

class DiscountRepository
{
    /**
     * @param $id
     * @return Discount
     * @throws NotFoundHttpException
     */
    public function find($id): Discount
    {
        if(!$discount = Discount::findOne($id))
        {
            throw new NotFoundHttpException('Discount not found');
        }
        return $discount;
    }

    /**
     * @param Discount $discount
     * @return Discount
     * @throws \DomainException
     */
    public function save(Discount $discount): Discount
    {
        if(!$discount->save())
        {
            throw new \DomainException('Discount save error');
        }
        return $discount;
    }

    /**
     * @param Discount $discount
     * @return Discount
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Discount $discount): Discount
    {
        if(!$discount->delete())
        {
            throw new \DomainException('Discount remove error');
        }
        return $discount;
    }
}