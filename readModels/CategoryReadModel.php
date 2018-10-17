<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\readModels;


use madetec\crm\entities\Category;
use yii\web\NotFoundHttpException;

class CategoryReadModel
{
    /**
     * @param $id
     * @return Category
     * @throws NotFoundHttpException
     */
    public function find($id): Category
    {
        if(!$category = Category::findOne($id))
        {
            throw new NotFoundHttpException('Category not found');
        }
        return $category;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     * @throws NotFoundHttpException
     */
    public function findAll()
    {
        if(!$categories = Category::find()->all())
        {
            throw new NotFoundHttpException('Categories not found');
        }
        return $categories;
    }

    /**
     * @param $slug
     * @return Category|null
     * @throws NotFoundHttpException
     */
    public function findBySlug($slug)
    {
        if(!$category = Category::findOne(['slug' => $slug]))
        {
            throw new NotFoundHttpException('Categories not found');
        }
        return $category;
    }


    public function findAllPopular()
    {
        return Category::find()->orderBy(['views' => SORT_DESC])->all();
    }

}