<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\readModels;


use madetec\crm\entities\Category;
use madetec\crm\entities\CategoryAssignment;
use madetec\crm\entities\Product;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProductReadModel
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


    public function findAllActive($orderBy = null): ActiveDataProvider
    {
        $query = Product::find()->active();
        if ($orderBy) {
            $query->orderBy([$orderBy => SORT_DESC]);
        }else{
            $query->orderBy(new Expression('rand()'));
        }
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);
    }

    public function findByCategoryId(Category $category): ActiveDataProvider
    {
        $ids = ArrayHelper::getColumn(CategoryAssignment::find()->where(['category_id' => $category->id])->all(), 'product_id');
        $products = ArrayHelper::getColumn(Product::find()->select('id')->where(['category_id' => $category->id])->asArray()->all(), 'id');
        $ids = ArrayHelper::merge($products, $ids);
        return new ActiveDataProvider([
            'query' => Product::find()
                ->where(['id' => $ids])
                ->active(),
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);
    }

    public function findAllActiveForWidget()
    {
        return Product::find()->active()->orderBy(['views' => SORT_DESC])->limit(8)->all();
    }
}