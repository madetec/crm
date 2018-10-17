<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\Order;
use madetec\crm\forms\OrderForm;
use madetec\crm\repositories\ClientRepository;
use madetec\crm\repositories\OrderRepository;
use madetec\crm\repositories\ProductRepository;

/**
 * @property ProductRepository $products
 * @property ClientRepository $clients
 * @property OrderRepository $orders
 */
class OrderManageService
{
    private $products;
    private $clients;
    private $orders;

    public function __construct(
        ProductRepository $productRepository,
        ClientRepository $clientRepository,
        OrderRepository $orderRepository
    )
    {
        $this->products = $productRepository;
        $this->clients = $clientRepository;
        $this->orders = $orderRepository;
    }

    /**
     * @param OrderForm $form
     * @return Order
     * @throws \DomainException
     * @throws \LogicException
     * @throws \yii\web\NotFoundHttpException
     */
    public function create(OrderForm $form): Order
    {
        $client = $this->clients->find($form->client);
        $order = Order::create($client->id, $form->status);

        foreach ($form->products as $productForm) {
            $product = $this->products->find($productForm->product);
            $order->assignProduct($productForm->product, $productForm->quantity);
            $product->downQuantity($productForm->quantity);
            $this->products->save($product);
        }
        $this->orders->save($order);

        return $order;
    }

    /**
     * @param $id
     * @param OrderForm $form
     * @return Order
     * @throws \DomainException
     * @throws \LogicException
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit($id, OrderForm $form): Order
    {
        $order = $this->orders->find($id);

        $order->revokeProducts();
        $this->orders->save($order);

        $client = $this->clients->find($form->client);
        $order->edit($client->id);

        foreach ($form->products as $productForm) {

            $product = $this->products->find($productForm->product);

            foreach ($form->_order->orderProducts as $orderProduct) {

                if ($orderProduct->product_id == $product->id) {

                    $product->upQuantity($orderProduct->quantity);

                    $this->products->save($product);
                }
            }

            $order->assignProduct($productForm->product, $productForm->quantity);
            $product->downQuantity($productForm->quantity);
            $this->products->save($product);
        }
        $this->orders->save($order);
        return $order;
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \LogicException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function remove($id)
    {
        $order = $this->orders->find($id);
        foreach ($order->orderProducts as $orderProduct) {
            $product = $this->products->find($orderProduct->product_id);
            $product->upQuantity($orderProduct->quantity);
            $this->products->save($product);
        }
        $this->orders->remove($order);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function statusNew($id)
    {
        $order = $this->orders->find($id);
        $order->statusNew();
        $this->orders->save($order);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function statusSold($id)
    {
        $order = $this->orders->find($id);
        $order->statusSold();
        $this->orders->save($order);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function statusCanceled($id)
    {
        $order = $this->orders->find($id);
        $order->statusCanceled();
        $this->orders->save($order);
    }
}