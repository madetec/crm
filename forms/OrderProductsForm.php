<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;

use madetec\crm\entities\OrderProducts;
use madetec\crm\entities\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property int $product;
 * @property int $quantity;
 */
class OrderProductsForm extends Model
{
    public $product;
    public $quantity;

    public function __construct(OrderProducts $orderProducts = null, array $config = [])
    {
        if ($orderProducts) {
            $this->product = $orderProducts->product_id;
            $this->quantity = $orderProducts->quantity;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['product', 'quantity'], 'required'],
            [['product'], 'integer'],
            ['quantity', 'double'],
        ];
    }

    public function getProductList(): array
    {
        return ArrayHelper::map(Product::find()->active()->asArray()->all(), 'id', function ($model) {
            return $model['name'] . ' (' . $model['article'] . ')';
        });
    }

    public function attributeLabels()
    {
        return [
            'product' => 'Товар',
            'quantity' => 'Количество',
        ];
    }
}