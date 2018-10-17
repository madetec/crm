<?php
namespace madetec\crm\widgets\product;

use madetec\crm\readModels\CategoryReadModel;
use madetec\crm\readModels\ProductReadModel;
use Yii;
use yii\bootstrap\Widget;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class Category
 * @package app\widgets
 * @property ProductReadModel $products;
 */
class PopularProducts extends Widget
{
    public $products;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->products = new ProductReadModel();
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function run()
    {
        try{
           $products = $this->products->findAllActiveForWidget();
        }catch (\Exception $e){
            $products = [];
        }
        return $this->render('popularProducts',[
            'products' => $products
        ]);
    }
}
