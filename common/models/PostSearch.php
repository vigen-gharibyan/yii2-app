<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $safe = ['created_at', 'updated_at', 'title', 'content'];

        return [
            [['id', 'created_by', 'created_at', 'updated_at', 'enabled'], 'integer'],
            [$safe, 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Post::find();
        $query->joinWith(['postLangs']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['title'] = [
            'asc'  => ['title' => SORT_ASC],
            'desc' => ['title' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['content'] = [
            'asc'  => ['content' => SORT_ASC],
            'desc' => ['content' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
                'id' => $this->id,
                'created_by' => $this->created_by,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'enabled' => $this->enabled,
            ])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
