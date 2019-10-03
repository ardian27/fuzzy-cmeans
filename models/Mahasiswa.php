<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mahasiswa".
 *
 * @property int $nim
 * @property string $nama
 * @property string $tahun_masuk
 */
class Mahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim'], 'required'],
            [['nim'], 'integer'],
            [['tahun_masuk'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['nim'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nim' => 'Nim',
            'nama' => 'Nama',
            'tahun_masuk' => 'Tahun Masuk',
        ];
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $mk= MataKuliah::find()->all();
            $data=array();

            foreach($mk as $key=>$value){
                $data[] = [null,$this->nim,$value->mata_kuliah,0];
            }
            Yii::$app->db
            ->createCommand()
            ->batchInsert('nilai', ['id_nilai','nim', 'mata_kuliah','nilai'],$data)
            ->execute();

            return true;
        } else {
            return false;
        }
    }
}