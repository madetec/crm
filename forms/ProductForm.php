<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;

use madetec\crm\entities\Product;

/**
 * @package madetec\crm\forms
 * @property PhotosForm $photos
 * @property CategoriesForm $categories
 */
class ProductForm extends CompositeForm
{
    public $name;
    public $article;
    public $price;
    public $old_price;
    public $params;
    public $quantity;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product) {
            $this->name = $product->name;
            $this->article = $product->article;
            $this->price = $product->price;
            $this->old_price = $product->old_price;
            $this->params = $product->params;
            $this->quantity = $product->quantity;
            $this->categories = new CategoriesForm($product);
        } else {
            $this->categories = new CategoriesForm();
        }
        $this->photos = new PhotosForm();

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'article'], 'string'],
            [['price', 'old_price'], 'double'],
            [['params'], 'string'],
            [['quantity'], 'integer'],
        ];
    }


    protected function internalForms(): array
    {
        return ['photos', 'categories'];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Состояние',
            'article' => 'Артикул',
            'name' => 'Нименование',
            'category_id' => 'Категория',
            'categories' => 'Сопутсвующие категорий',
            'quantity' => 'Количество',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'params' => 'дополнительные параметры',
        ];
    }
}