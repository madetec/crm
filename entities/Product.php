<?php

namespace madetec\crm\entities;

use madetec\crm\queries\ProductQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int $category_id
 * @property int $main_photo_id
 * @property string $name
 * @property string $article
 * @property float $price
 * @property float $old_price
 * @property string $params
 * @property int $quantity
 * @property int $status
 * @property int $views
 *
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 *
 * @property CategoryAssignment $categoryAssignments[]
 * @property Category $categories[]
 * @property Category $category
 * @mixin ImageUploadBehavior
 */
class Product extends \yii\db\ActiveRecord
{

    public const STATUS_ACTIVE = 10;
    public const STATUS_DRAFT = 20;

    public static function create($name, $category_id, $article, $price, $old_price, $params, $quantity): self
    {
        $category = new static();
        $category->name = $name;
        $category->article = $article;
        $category->price = $price;
        $category->old_price = $old_price;
        $category->params = $params;
        $category->quantity = $quantity;
        $category->category_id = $category_id;

        return $category;
    }

    public function edit($name, $category_id, $article, $price, $old_price, $params, $quantity)
    {
        $this->name = $name;
        $this->article = $article;
        $this->price = $price;
        $this->old_price = $old_price;
        $this->params = $params;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
    }

    public function upView()
    {
        $this->views++;
    }

    public function downView()
    {
        $this->views--;
    }

    /**
     * @throws \DomainException
     */
    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Product is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * @param int $quantity
     * @throws \LogicException
     */
    public function downQuantity(int $quantity)
    {
        if($this->quantity > $quantity)
        {
            $this->quantity = $this->quantity - $quantity;
            return;
        }
        throw new \LogicException('Not in such quantity');
    }

    /**
     * @param int $quantity
     * @throws \LogicException
     */
    public function upQuantity(int $quantity)
    {
        if($quantity > 0)
        {
            $this->quantity = $this->quantity + $quantity;
            return;
        }
        throw new \LogicException('Not in such quantity');
    }

    /**
     * @throws \DomainException
     */
    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Product is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    // Categories

    public function assignCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            /**
             * @var CategoryAssignment $assignment
             */
            if ($assignment->isForCategory($id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignments;
    }

    /**
     * @param $id
     * @throws \DomainException
     */
    public function revokeCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment) {
            /**
             * @var CategoryAssignment $assignment
             */
            if ($assignment->isForCategory($id)) {
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeCategories(): void
    {
        $this->categoryAssignments = [];
    }

    // Photos

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
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
        return $this->hasMany(Photo::class, ['product_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['product_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
    }

    public static function tableName()
    {
        return '{{%products}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['photos','categoryAssignments'],
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

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
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

    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Состояние',
            'article' => 'Артикул',
            'name' => 'Нименование',
            'category_id' => 'Категория',
            'categories' => 'Сопутствующие категорий',
            'quantity' => 'Количество',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'params' => 'дополнительные параметры',
        ];
    }

}
