<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\readModels;


use madetec\crm\entities\News;
use yii\data\ActiveDataProvider;

class NewsReadModel
{
    public function findAll()
    {
        return new ActiveDataProvider([
            'query' => News::find()
                ->where(['status' => News::STATUS_PUBLISHED])
                ->andWhere(['<=', 'published_at', time()])
        ]);
    }

    public function find($id)
    {
        return News::findOne($id);
    }
}