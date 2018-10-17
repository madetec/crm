<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;

use madetec\crm\entities\Category;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class CategoryForm
 * @package madetec\crm\forms
 * @property $name
 * @property UploadedFile $image
 */
class CategoryForm extends Model
{
    public $name;
    public $image;

    public function __construct(Category $category = null, array $config = [])
    {
        if($category){
            $this->name = $category->name;
            $this->image = $category->image;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['image', 'file', 'extensions' => 'jpeg, gif, png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'image' => 'Image',
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->image = UploadedFile::getInstance($this, 'image');
            return true;
        }
        return false;
    }
}