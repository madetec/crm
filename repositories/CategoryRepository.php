<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;


use madetec\crm\entities\Category;
use yii\web\NotFoundHttpException;

class CategoryRepository
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
     * @param Category $category
     * @return Category
     * @throws \DomainException
     */
    public function save(Category $category): Category
    {
        if(!$category->save())
        {
            throw new \DomainException('Category save error');
        }
        return $category;
    }

    /**
     * @param Category $category
     * @return Category
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Category $category): Category
    {
        if(!$category->delete())
        {
            throw new \DomainException('Category remove error');
        }
        return $category;
    }
}