<?php

namespace madetec\crm\entities;

use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property integer $views
 *
 * @property Product[] $products
 * @mixin ImageUploadBehavior
 */
class Category extends \yii\db\ActiveRecord
{

    public static function create($name, $slug, $image): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->image = $image;
        return $category;
    }

    public function edit($name, $slug, $image)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->image = $image;
    }

    public function upView()
    {
        $this->views++;
    }

    public function downView()
    {
        $this->views--;
    }

    public static function tableName()
    {
        return '{{%categories}}';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'slug' => 'Ссылка',
            'image' => 'Изображение',
        ];
    }

    public function behaviors()
    {
        return [
            [


                'class' => ImageUploadBehavior::class,
                'attribute' => 'image',
                'thumbs' => [
                    'admin' => ['width' => 75, 'height' => 75],
                    'thumb' => ['width' => 300, 'height' => 300],
                ],
                'filePath' => '@uploads/store/categories/[[id]]/[[pk]].[[extension]]',
                'fileUrl' => '@uploadsUrl/store/categories/[[id]]/[[pk]].[[extension]]',
                'thumbPath' => '@uploads/cache/categories/[[id]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '@uploadsUrl/cache/categories/[[id]]/[[profile]]_[[pk]].[[extension]]',
            ]
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }
}
