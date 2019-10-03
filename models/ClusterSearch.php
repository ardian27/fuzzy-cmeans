<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cluster;

/**
 * ClusterSearch represents the model behind the search form about `app\models\Cluster`.
 */
class ClusterSearch extends Cluster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cluster', 'jumlah_cluster', 'max_iterasi'], 'integer'],
            [['min_error', 'fuzziness'], 'number'],
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
        $query = Cluster::find();

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
            'id_cluster' => $this->id_cluster,
            'min_error' => $this->min_error,
            'jumlah_cluster' => $this->jumlah_cluster,
            'max_iterasi' => $this->max_iterasi,
            'fuzziness' => $this->fuzziness,
        ]);

        return $dataProvider;
    }
}
