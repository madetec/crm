<?php
namespace madetec\crm\widgets\category;

use madetec\crm\readModels\CategoryReadModel;
use Yii;
use yii\bootstrap\Widget;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class Category
 * @package app\widgets
 * @property CategoryReadModel $categories;
 */
class PopularCategory extends Widget
{
    public $categories;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->categories = new CategoryReadModel();
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function run()
    {
        try{
            $categories = $this->categories->findAllPopular();
        }catch (\Exception $e){
            $categories = [];
        }
        return $this->render('popular',[
            'categories' => $categories
        ]);
    }
}
