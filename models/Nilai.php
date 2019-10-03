<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nilai".
 *
 * @property int $id_nilai
 * @property int $nim
 * @property int $id_mata_kuliah
 * @property string $nilai
 */
class Nilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'nilai'], 'integer'],
            [['mata_kuliah'], 'string', 'max' => 255],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_nilai' => 'Id Nilai',
            'nim' => 'Nim',
            'mata_kuliah' => 'Mata Kuliah',
            'nilai' => 'Nilai',
        ];
    }

    public function getUpdateNilai(){
        return $this->nilai = $this->nilai;
    } 

    public function getMataKuliah()
    {
        return $this->hasOne(MataKuliah::className(), ['mata_kuliah' => 'mata_kuliah']);
    }
}
