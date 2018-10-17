<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;

use madetec\crm\entities\Product;
use yii\web\NotFoundHttpException;

class ProductRepository
{
    /**
     * @param $id
     * @return Product
     * @throws NotFoundHttpException
     */
    public function find($id): Product
    {
        if(!$product = Product::findOne($id))
        {
            throw new NotFoundHttpException('Product not found');
        }
        return $product;
    }

    /**
     * @param Product $product
     * @return Product
     * @throws \DomainException
     */
    public function save(Product $product): Product
    {
        if(!$product->save())
        {
            throw new \DomainException('Product save error');
        }
        return $product;
    }

    /**
     * @param Product $product
     * @return Product
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Product $product): Product
    {
        if(!$product->delete())
        {
            throw new \DomainException('Product remove error');
        }
        return $product;
    }
}