<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;

use madetec\crm\entities\Discount;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $text
 * @property integer $published_at
 * @property integer $expired_at
 * @property integer $status
 * @property UploadedFile $photo
 */
class DiscountForm extends Model
{
    public $photo;
    public $title;
    public $description;
    public $text;
    public $published_at;
    public $expired_at;
    public $status;

    public function __construct(Discount $discount = null, array $config = [])
    {
        if($discount){
            $this->title = $discount->title;
            $this->description = $discount->description;
            $this->text = $discount->text;
            $this->published_at = date('d-m-Y',$discount->published_at);
            $this->expired_at = date('d-m-Y',$discount->expired_at);
            $this->status = $discount->status;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title','description','published_at','expired_at','status'], 'required'],
            [['title','description','text'], 'string'],
            ['status', 'integer'],
            [['published_at','expired_at'], 'date', 'format' => 'php:d-m-Y'],
            ['photo', 'image'],
        ];
    }

    public function getStatusList()
    {
        return [
            Discount::STATUS_ACTIVATED => 'Активный',
            Discount::STATUS_DRAFT => 'Черновик',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Картинка',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'slug' => 'ссылка',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'published_at' => 'Дата начала',
            'expired_at' => 'Дата окончания',
            'status' => 'Состояние',
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }
}