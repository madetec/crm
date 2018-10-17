<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 *
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName(): string
    {
        return '{{%photos}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'thumbs' => [
                    'large' => ['width' => 600, 'height' => 600],
                    'thumb' => ['width' => 300, 'height' => 300],
                    'small' => ['width' => 100, 'height' => 100],
                    'admin' => ['width' => 75, 'height' => 75],
                ],
                'filePath' => '@uploads/store/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@uploadsUrl/store/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@uploads/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@uploadsUrl/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
            ],
        ];
    }
}