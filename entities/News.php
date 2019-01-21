<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\entities;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * @property integer id
 * @property string title
 * @property string description
 * @property string text
 * @property string slug
 * @property integer main_photo_id
 * @property integer created_at
 * @property integer updated_at
 * @property integer published_at
 * @property integer status
 *
 * @property NewsPhoto[] photos
 * @property NewsPhoto mainPhoto
 */
class News extends ActiveRecord
{
    const STATUS_PUBLISHED = 10;
    const STATUS_NOT_PUBLISHED = 20;

    public static function create($title, $description, $text, $published_at, $status): self
    {
        $news = new static();
        $news->title = $title;
        $news->slug = Inflector::slug($title);
        $news->description = $description;
        $news->text = $text;
        $news->published_at = $published_at;
        $news->created_at = time();
        $news->updated_at = time();
        $news->status = $status;
        return $news;
    }

    public function edit($title, $description, $text, $published_at, $status): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->published_at = $published_at;
        $this->status = $status;
    }

    // Photos

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = NewsPhoto::create($file);
        $this->updatePhotos($photos);

    }

    /**
     * @param $id
     * @throws \DomainException
     */
    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    /**
     * @param $id
     * @throws \DomainException
     */
    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    /**
     * @param $id
     * @throws \DomainException
     */
    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(NewsPhoto::class, ['news_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(NewsPhoto::class, ['id' => 'main_photo_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['photos'],
            ]
        ];
    }

    public function afterSave($insert, $changedAttributes): void
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
            return true;
        }
        return false;
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function statusList()
    {
        return [
            News::STATUS_PUBLISHED => 'Опубликовать',
            News::STATUS_NOT_PUBLISHED => 'Не опубликововать',
        ];
    }

    public static function statusName($status)
    {
        switch ($status){
            case News::STATUS_PUBLISHED:
                return 'Опубликован';
            case News::STATUS_NOT_PUBLISHED:
                return 'Не опубликован';
        }
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Загаловок',
            'description' => 'Описание',
            'text' => 'Текст',
            'published_at' => 'Дата публикаций',
            'created_at' => 'Дата создание',
            'updated_at' => 'Дата обновления',
            'status' => 'Состояние',
        ];
    }


    public static function tableName(): string
    {
        return '{{%news}}';
    }
}