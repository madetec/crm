<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\Category;
use madetec\crm\forms\CategoryForm;
use madetec\crm\repositories\CategoryRepository;
use yii\helpers\Inflector;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class CategoryManageService
 * @package madetec\crm\services
 * @property CategoryRepository $categories
 */
class CategoryManageService
{
    private $categories;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categories = $categoryRepository;
    }

    /**
     * @param CategoryForm $form
     * @return Category
     * @throws \DomainException
     */
    public function create(CategoryForm $form): Category
    {
        $category = Category::create($form->name, Inflector::slug($form->name), $form->image);
        $this->categories->save($category);
        return $category;
    }

    /**
     * @param $id
     * @param CategoryForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit($id, CategoryForm $form): void
    {
        $category = $this->categories->find($id);
        $category->edit($form->name, Inflector::slug($form->name), $form->image);
        $this->categories->save($category);
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
        $category = $this->categories->find($id);
        $this->categories->remove($category);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function addView($id)
    {
        $category = $this->categories->find($id);
        $category->upView();
        $this->categories->save($category);
    }
}