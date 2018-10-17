<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\readModels;


use madetec\crm\entities\Warranty;
use yii\web\NotFoundHttpException;

class WarrantyReadModel
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
     * @return array|\yii\db\ActiveRecord[]
     * @throws NotFoundHttpException
     */
    public function findAll()
    {
        if(!$warranties = Warranty::find()->all())
        {
            throw new NotFoundHttpException('Categories not found');
        }
        return $warranties;
    }

    /**
     * @param $slug
     * @return Warranty|null
     * @throws NotFoundHttpException
     */
    public function findBySlug($slug)
    {
        if(!$warranty = Warranty::findOne(['slug' => $slug]))
        {
            throw new NotFoundHttpException('Categories not found');
        }
        return $warranty;
    }


    public function findAllPopular()
    {
        return Warranty::find()->orderBy(['views' => SORT_DESC])->all();
    }

}