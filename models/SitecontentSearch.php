<?php

namespace thyseus\sitecontent\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use thyseus\sitecontent\models\Sitecontent;

/**
 * SitecontentSearch represents the model behind the search form about `app\models\Sitecontent`.
 */
class SitecontentSearch extends Sitecontent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'created_by', 'updated_by', 'position', 'status', 'views'], 'integer'],
            [['language', 'slug', 'title', 'content', 'created_at', 'updated_at'], 'safe'],
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
        $query = Sitecontent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        // grid filtering conditions
        $query->filterWhere([
            'id' => $this->id,
            'parent' => $this->parent,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'position' => $this->position,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'views' => $this->views,
            'language' => $this->language,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
