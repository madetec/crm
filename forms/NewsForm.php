<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;


use madetec\crm\entities\News;

/**
 * @property string title
 * @property string description
 * @property string text
 * @property integer published_at
 * @property integer status
 * @property NewsPhotosForm photos
 */
class NewsForm extends CompositeForm
{
    public $title;
    public $description;
    public $text;
    public $published_at;
    public $status;

    private $_news = null;

    public function __construct(News $news = null, array $config = [])
    {
        if ($news) {
            $this->title = $news->title;
            $this->description = $news->description;
            $this->text = $news->text;
            $this->published_at = date('d-m-Y', $news->published_at);
            $this->status = $news->status;
            $this->_news = $news;
        }

        $this->photos = new NewsPhotosForm();

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'description', 'text', 'published_at', 'status'], 'required'],
            [['title', 'description', 'text'], 'trim'],
            [['title', 'description', 'text'], 'string'],
            ['status', 'integer'],
            ['published_at', 'date', 'format' => 'php:d-m-Y']
        ];
    }


    public function statusList()
    {
        return [
            News::STATUS_PUBLISHED => 'Опубликовать',
            News::STATUS_NOT_PUBLISHED => 'Не опубликововать',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Загаловок',
            'description' => 'Описание',
            'text' => 'Текст',
            'published_at' => 'Дата публикаций',
            'status' => 'Состояние',
        ];
    }

    protected function internalForms(): array
    {
        return ['photos'];
    }

    public function isNewRecord()
    {
        return $this->_news == null;
    }
}