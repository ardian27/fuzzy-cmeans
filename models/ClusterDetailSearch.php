<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClusterDetail;

/**
 * ClusterDetailSearch represents the model behind the search form about `app\models\ClusterDetail`.
 */
class ClusterDetailSearch extends ClusterDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cluster_detail', 'nim'], 'integer'],
            [['id_cluster', 'hasil'], 'safe'],
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
        $query = ClusterDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'cluster_detail' => $this->cluster_detail,
            'nim' => $this->nim,
        ]);

        $query->andFilterWhere(['like', 'id_cluster', $this->id_cluster])
            ->andFilterWhere(['like', 'hasil', $this->hasil]);

        return $dataProvider;
    }
}
