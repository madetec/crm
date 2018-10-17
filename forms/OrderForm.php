<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;


use madetec\crm\entities\Client;
use madetec\crm\entities\Order;
use yii\helpers\ArrayHelper;

/**
 * @property int $client;
 * @property int $product;
 * @property int $quantity;
 * @property int $status;
 * @property Order $_order;
 * @property OrderProductsForm[] $products;
 */
class OrderForm extends CompositeForm
{
    public $client;
    public $status;

    public $_order;

    public function __construct(Order $order = null, array $config = [])
    {
        if ($order) {
            $this->client = $order->client->id;
            $this->status = $order->status;
            $this->_order = $order;
            $products=[];
            foreach ($order->orderProducts as $product) {
                $products[] = new OrderProductsForm($product);
            }
            $this->products = $products;
        } else {
            $this->products = [new OrderProductsForm()];
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['client', 'status'], 'required'],
            [['client', 'status'], 'integer'],
        ];
    }

    public function getClientList(): array
    {
        return ArrayHelper::map(Client::find()->asArray()->all(), 'id', 'name');
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $request = \Yii::$app->request->post();
            $productForms = count($request['OrderProductsForm']);
            $forms = [];
            for ($i = 0; $i < $productForms; $i++) {
                $forms[] = new OrderProductsForm();
            }
            $this->products = $forms;
            $this->load($request);
            return true;
        }
        return false;
    }

    public function getStatusList(): array
    {
        return [
            Order::STATUS_NEW => 'Новый',
            Order::STATUS_SOLD => 'Продан',
            Order::STATUS_CANCELED => 'Отменен',
        ];
    }

    public function attributeLabels()
    {
        return [
            'client' => 'Клиент',
            'products' => 'Товары',
            'status' => 'Состояние',
        ];
    }

    protected function internalForms(): array
    {
        return ['products'];
    }
}