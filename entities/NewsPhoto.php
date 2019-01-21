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
 * @property integer $news_id
 * @property integer $sort
 *
 * @mixin ImageUploadBehavior
 */
class NewsPhoto extends ActiveRecord
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
        return '{{%news_photos}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'thumbs' => [
                    'preview' => ['width' => 442, 'height' => 442],
                    'index' => ['width' => 830, 'height' => 500],
                    'thumb' => ['width' => 298, 'height' => 220],
                    'admin' => ['width' => 75, 'height' => 75],
                ],
                'filePath' => '@uploads/store/news/[[attribute_news_id]]/[[id]].[[extension]]',
                'fileUrl' => '@uploadsUrl/store/news/[[attribute_news_id]]/[[id]].[[extension]]',
                'thumbPath' => '@uploads/cache/news/[[attribute_news_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@uploadsUrl/cache/news/[[attribute_news_id]]/[[profile]]_[[id]].[[extension]]',
            ],
        ];
    }
}