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
     * @return mixed
     */
    public function findAll()
    {
        return Discount::find()->where(['status' => Discount::STATUS_ACTIVATED])->all();
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