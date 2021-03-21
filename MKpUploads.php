<?php

namespace app\modules\kp\models;

use app\modules\users\models\User;
use Yii;

/**
 * This is the model class for table "m_kp__uploads".
 *
 * @property int $id
 *
 * @property int $kp_id
 * @property Kp $kp
 *
 * @property int $team_id
 *
 * @property int $created_at
 *
 * @property User $createdBy
 * @property int $created_by
 *
 * @property int $updated_at
 *
 * @property User $updatedBy
 * @property int $updated_by
 *
 * @property int $markdel_by Кем удалено
 * @property User $markdelBy
 *
 * @property string $markdel_at Когда удалено
 *
 * @property int $isDeleted - удалить... пережиток прошлого
 *
 * @property string $filename_original Оригинальное название файла
 * @property string $md5
 * @property string $ext Расширение файла
 * @property string $mimetype
 * @property int $size
 * @property int $type_anketa Тип файла Анкета для нового покупателя
 *
 */
class MKpUploads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_kp__uploads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kp_id', 'team_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'markdel_by', 'isDeleted', 'size', 'type_anketa'], 'integer'],
            [['markdel_at'], 'safe'],
            [['filename_original', 'md5', 'ext', 'mimetype'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kp_id' => 'Kp ID',
            'team_id' => 'Team ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'markdel_by' => 'Кем удалено',
            'markdel_at' => 'Когда удалено',
            'isDeleted' => 'Is Deleted',
            'filename_original' => 'Оригинальное название файла',
            'md5' => 'Md5',
            'ext' => 'Расширение файла',
            'mimetype' => 'Mimetype',
            'size' => 'Size',
            'type_anketa' => 'Тип файла Анкета для нового покупателя',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MKpUploadsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MKpUploadsQuery(get_called_class());
    }

    public function getKp(){
        return $this->hasOne(Kp::className(), ['id' => 'kp_id']);
    }

    public function getMarkdelBy(){
        return $this->hasOne(User::className(), ['id' => 'markdel_by']);
    }

    public function getCreatedBy(){
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy(){
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
