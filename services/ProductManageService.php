<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\Product;
use madetec\crm\forms\PhotosForm;
use madetec\crm\forms\ProductForm;
use madetec\crm\repositories\CategoryRepository;
use madetec\crm\repositories\ProductRepository;

/**
 * Class ProductManageService
 * @package madetec\crm\services
 * @property ProductRepository $products
 * @property CategoryRepository $categories
 */
class ProductManageService
{
    private $products;
    private $categories;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->products = $productRepository;
        $this->categories = $categoryRepository;
    }

    /**
     * @param ProductForm $form
     * @return Product
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function create(ProductForm $form): Product
    {

        $category = $this->categories->find($form->categories->main);

        $product = Product::create(
            $form->name,
            $category->id,
            $form->article,
            $form->price,
            $form->old_price,
            $form->params,
            $form->quantity
        );

        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->find($otherId);
            $product->assignCategory($category->id);
        }

        if (is_array($form->photos->files)) {
            foreach ($form->photos->files as $file) {
                $product->addPhoto($file);
            }
        }
        $this->products->save($product);
        return $product;
    }

    /**
     * @param $id
     * @param ProductForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit($id, ProductForm $form): void
    {
        $product = $this->products->find($id);
        $category = $this->categories->find($form->categories->main);

        $product->edit(
            $form->name,
            $category->id,
            $form->article,
            $form->price,
            $form->old_price,
            $form->params,
            $form->quantity
        );

        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->find($otherId);
            $product->assignCategory($category->id);
        }

        $this->products->save($product);
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
        $product = $this->products->find($id);
        $this->products->remove($product);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function activate($id): void
    {
        $product = $this->products->find($id);
        $product->activate();
        $this->products->save($product);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function draft($id): void
    {
        $product = $this->products->find($id);
        $product->draft();
        $this->products->save($product);
    }

    /**
     * @param $id
     * @param PhotosForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function addPhotos($id, PhotosForm $form): void
    {
        $product = $this->products->find($id);
        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }
        $this->products->save($product);
    }

    /**
     * @param $id
     * @param $photoId
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function movePhotoUp($id, $photoId): void
    {
        $product = $this->products->find($id);
        $product->movePhotoUp($photoId);
        $this->products->save($product);
    }

    /**
     * @param $id
     * @param $photoId
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function movePhotoDown($id, $photoId): void
    {
        $product = $this->products->find($id);
        $product->movePhotoDown($photoId);
        $this->products->save($product);
    }

    /**
     * @param $id
     * @param $photoId
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function removePhoto($id, $photoId): void
    {
        $product = $this->products->find($id);
        $product->removePhoto($photoId);
        $this->products->save($product);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function addView($id)
    {
        $product = $this->products->find($id);
        $product->upView();
        $this->products->save($product);
    }
}