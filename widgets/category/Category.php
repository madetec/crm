<?php

namespace madetec\crm\widgets\category;

use madetec\crm\readModels\CategoryReadModel;
use yii\bootstrap\Widget;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class Category
 * @package app\widgets
 * @property CategoryReadModel $categories;
 */
class Category extends Widget
{
    public $categories;
    public $type = null;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->categories = new CategoryReadModel();
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        try{
            $categories = $this->categories->findAll();
        }catch (\Exception $e){
            $categories = [];
        }

        return $this->render('category', [
            'categories' => $categories,
            'type' => $this->type
        ]);
    }
}
