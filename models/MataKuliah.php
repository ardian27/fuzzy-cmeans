<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mata_kuliah".
 *
 * @property int $id_mata_kuliah
 * @property string $mata_kuliah
 */
class MataKuliah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mata_kuliah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mata_kuliah','bidang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mata_kuliah' => 'Id Mata Kuliah',
            'mata_kuliah' => 'Mata Kuliah',
            'bidang' => 'Kebidangan',
        ];
    }
    
}
