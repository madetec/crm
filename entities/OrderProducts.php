<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $quantity
 *
 * @property Product $product
 */
class OrderProducts extends ActiveRecord
{
    public static function create($product_id, $quantity)
    {
        $order = new static();
        $order->product_id = $product_id;
        $order->quantity = $quantity;
        return $order;
    }

    public function edit($product_id, $quantity)
    {
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function isForProductId($product_id)
    {
        return $this->product_id == $product_id;
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function tableName()
    {
        return '{{%order_products}}';
    }

    public function attributeLabels()
    {
        return [
            'order_id' => 'Заказ',
            'product_id' => 'Товар',
            'quantity' => 'Количество',
        ];
    }
}