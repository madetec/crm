<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;


use madetec\crm\entities\News;
use yii\web\NotFoundHttpException;

class NewsRepository
{
    public function find($id): News
    {
        if (!$news = News::findOne($id)) {
            throw new NotFoundHttpException('News not found.');
        }
        return $news;
    }

    public function save(News $news): void
    {
        if (!$news->save()) {
            throw new \DomainException('News save error');
        }
    }

    public function remove(News $news): void
    {
        if (!$news->delete()) {
            throw new \DomainException('News remove error');
        }
    }
}