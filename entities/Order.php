<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $client_id
 * @property integer $status
 * @property integer $created_at
 *
 * @property Product[] $products
 * @property OrderProducts[] $orderProducts
 * @property Client $client
 */
class Order extends ActiveRecord
{
    public const STATUS_NEW = 10;
    public const STATUS_SOLD = 20;
    public const STATUS_CANCELED = 30;

    public static function create($client_id, $status)
    {
        $order = new static();
        $order->client_id = $client_id;
        $order->status = $status;
        $order->created_at = time();
        return $order;
    }

    public function edit($client_id)
    {
        $this->client_id = $client_id;
    }

    public function assignProduct($product_id, $quantity)
    {
        $products = $this->orderProducts;

        foreach ($products as $product) {
            if ($product->isForProductId($product_id)) {
                $product->edit($product_id, $quantity);
                return;
            }
        }

        $products[] = OrderProducts::create($product_id, $quantity);
        $this->orderProducts = $products;
    }

    public function revokeProducts()
    {
        $this->orderProducts = [];
    }

    public function getOrderProducts(): ActiveQuery
    {
        return $this->hasMany(OrderProducts::class, ['order_id' => 'id']);
    }

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->via('orderProducts');
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    // status

    /**
     * @throws \DomainException
     */
    public function statusNew(): void
    {
        if ($this->isNew()) {
            throw new \DomainException('Status is already new');
        }
        $this->status = self::STATUS_NEW;
    }

    /**
     * @throws \DomainException
     */
    public function statusSold(): void
    {
        if ($this->isSold()) {
            throw new \DomainException('Status is already sold');
        }
        $this->status = self::STATUS_SOLD;
    }

    /**
     * @throws \DomainException
     */
    public function statusCanceled(): void
    {
        if ($this->isCanceled()) {
            throw new \DomainException('Status is already canceled');
        }
        $this->status = self::STATUS_CANCELED;

    }

    public function isNew(): bool
    {
        return $this->status == self::STATUS_NEW;
    }

    public function isSold(): bool
    {
        return $this->status == self::STATUS_SOLD;
    }

    public function isCanceled(): bool
    {
        return $this->status == self::STATUS_CANCELED;
    }

    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function attributeLabels()
    {
        return [
            'client_id' => 'Клиент',
            'products' => 'Товары',
            'quantity' => 'Количество',
            'status' => 'Состояние',
            'created_at' => 'Дата добавления',
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['orderProducts'],
            ]
        ];
    }
}