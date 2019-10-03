<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cluster_detail".
 *
 * @property int $cluster_detail
 * @property string $id_cluster
 * @property string $nim
 * @property string $hasil
 */
class ClusterDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cluster_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim'], 'integer'],
            [['id_cluster'], 'string', 'max' => 255],
            [['hasil'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cluster_detail' => 'Cluster Detail',
            'id_cluster' => 'Id Cluster',
            'nim' => 'Nim',
            'hasil' => 'Hasil',
        ];
    }
}
