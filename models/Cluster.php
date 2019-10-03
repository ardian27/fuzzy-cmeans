<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cluster".
 *
 * @property int $id_cluster
 * @property double $min_error
 * @property int $jumlah_cluster
 * @property int $max_iterasi
 * @property double $fuzziness
 */
class Cluster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cluster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min_error', 'fuzziness'], 'number'],
            [['jumlah_cluster', 'max_iterasi'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cluster' => 'Id Cluster',
            'min_error' => 'Min Error',
            'jumlah_cluster' => 'Jumlah Cluster',
            'max_iterasi' => 'Max Iterasi',
            'fuzziness' => 'Fuzziness',
        ];
    }
}
