<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string  $photo
 * @property string  $title
 * @property string  $description
 * @property string  $slug
 * @property string  $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published_at
 * @property integer $expired_at
 * @property integer $status
 */

class Discount extends ActiveRecord
{
    const STATUS_ACTIVATED = 10;
    const STATUS_EXPIRED = 15;
    const STATUS_DRAFT = 20;

    public static function create($photo, $title, $description, $slug, $text, $published_at, $expired_at, $status)
    {
        $discount = new static();
        $discount->photo = $photo;
        $discount->title = $title;
        $discount->description = $description;
        $discount->slug = $slug;
        $discount->text = $text;
        $discount->published_at = $published_at ?: time();
        $discount->expired_at = $expired_at ?: strtotime( "+1 month");
        $discount->status = $status;
        return $discount;
    }

    public function edit($photo, $title, $description, $slug, $text, $published_at, $expired_at, $status)
    {
        $this->photo = $photo;
        $this->title = $title;
        $this->description = $description;
        $this->slug = $slug;
        $this->text = $text;
        $this->published_at = $published_at;
        $this->expired_at = $expired_at;
        $this->status = $status;
    }

    /**
     * @throws \DomainException
     */
    public function activated(): void
    {
        if ($this->isActivated()) {
            throw new \DomainException('Status is already activated');
        }
        $this->status = self::STATUS_ACTIVATED;
    }

    /**
     * @throws \DomainException
     */
    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Status is already draft');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActivated(): bool
    {
        return $this->status == self::STATUS_ACTIVATED;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'thumbs' => [
                    'admin' => ['width' => 75, 'height' => 75],
                    'small' => ['width' => 500, 'height' => 400],
                    'big' => ['width' => 500, 'height' => 864],
                ],
                'filePath' => '@uploads/store/discounts/[[id]]/[[pk]].[[extension]]',
                'fileUrl' => '@uploadsUrl/store/discounts/[[id]]/[[pk]].[[extension]]',
                'thumbPath' => '@uploads/cache/discounts/[[id]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '@uploadsUrl/cache/discounts/[[id]]/[[profile]]_[[pk]].[[extension]]',
            ],
            TimestampBehavior::class
        ];
    }

    public static function tableName()
    {
        return '{{%discounts}}';
    }
}