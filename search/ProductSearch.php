<?php

namespace madetec\crm\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use madetec\crm\entities\Product;

/**
 * ProductSearch represents the model behind the search form of `madetec\crm\entities\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'quantity', 'main_photo_id'], 'integer'],
            [['name', 'article', 'params'], 'safe'],
            [['price', 'old_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'quantity' => $this->quantity,
            'main_photo_id' => $this->main_photo_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'article', $this->article])
            ->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }
}
