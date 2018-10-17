<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;


use madetec\crm\entities\Order;
use yii\web\NotFoundHttpException;

class OrderRepository
{
    /**
     * @param $id
     * @return Order
     * @throws NotFoundHttpException
     */
    public function find($id): Order
    {
        if(!$order = Order::findOne($id))
        {
            throw new NotFoundHttpException('Order not found');
        }
        return $order;
    }

    /**
     * @param Order $order
     * @return Order
     * @throws \DomainException
     */
    public function save(Order $order): Order
    {
        if(!$order->save())
        {
            throw new \DomainException('Order save error');
        }
        return $order;
    }

    /**
     * @param Order $order
     * @return Order
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Order $order): Order
    {
        if(!$order->delete())
        {
            throw new \DomainException('Order remove error');
        }
        return $order;
    }
}