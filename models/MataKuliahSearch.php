<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MataKuliah;

/**
 * MataKuliahSearch represents the model behind the search form about `app\models\MataKuliah`.
 */
class MataKuliahSearch extends MataKuliah
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_mata_kuliah'], 'integer'],
            [['mata_kuliah'], 'safe'],
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
        $query = MataKuliah::find();

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
            'id_mata_kuliah' => $this->id_mata_kuliah,
        ]);

        $query->andFilterWhere(['like', 'mata_kuliah', $this->mata_kuliah]);

        return $dataProvider;
    }
}
