<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\readModels;


use madetec\crm\entities\Discount;
use yii\web\NotFoundHttpException;

class DiscountReadModel
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
     * @return array|\yii\db\ActiveRecord[]
     * @throws NotFoundHttpException
     */
    public function findAll()
    {
        if(!$discounts = Discount::find()->all())
        {
            throw new NotFoundHttpException('Categories not found');
        }
        return $discounts;
    }

    /**
     * @param $slug
     * @return Discount|null
     * @throws NotFoundHttpException
     */
    public function findBySlug($slug)
    {
        if(!$discount = Discount::findOne(['slug' => $slug]))
        {
            throw new NotFoundHttpException('Categories not found');
        }
        return $discount;
    }


}