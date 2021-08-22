<?php

namespace app\modules\kp\models;

use app\modules\users\models\User;
use Yii;

/**
 * This is the model class for table "m_----__uploads".
 *
 * @property int $id - айди добавленного файла
 *
 * @property int $team_by - Команда по умолчанию, используется для возможности работать с группа команд (для распределение ролей)
 * @property Team $teamBy
 *
 * @property int $created_at  Добавлено когда
 *
 * @property User $createdBy Добавлено кем
 * @property int $created_by
 *
 * @property int $updated_at Когда обновлено
 *
 * @property User $updatedBy Кем обновлено
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
 * @property string $md5 - мд5 хеш файла, чтобы проверять на дубликаты на диске не загружать дубликаты, 
 *                         если файл является дубликатом, то в контроллере в методе actionCreate файл не загружаем, 
 *                         но добавляем запись о том, что файл относится к объекту
 * @property string $ext Расширение файла
 * @property string $mimetype - миме тип файла
 * @property int $size - размер файла
 *
 * ПОЛЕ ИДЕНТИФИКАТОР ОБЪЕКТА, к котором цепляем файл:
 *                             
 * @property int $object_id
 * @property Kp $object
 * @property Kp $kp
 *
 *
 * СПИСОК ИНДИВИДУАЛЬНЫХ ПОЛЕЙ:
 * @property int $type_anketa Тип файла Анкета для нового покупателя
 *
 *
 * sql код:
 
DROP TABLE IF EXISTS `m_XX__uploads`;
CREATE TABLE `m_XX__uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT NULL COMMENT 'Объект, к которому крепится файл',
  `team_by` int(11) DEFAULT NULL COMMENT 'Команда',
  `created_at` datetime DEFAULT NULL COMMENT 'Добавлено когда',
  `created_by` int(11) DEFAULT NULL COMMENT 'Добавлено кем',
  `updated_at` datetime DEFAULT NULL COMMENT 'Изменено когда',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Изменено кем',
  `markdel_by` int(11) DEFAULT NULL COMMENT 'Удалено кем',
  `markdel_at` datetime DEFAULT NULL COMMENT 'Удалено когда',
  `filename_original` varchar(255) DEFAULT NULL COMMENT 'Оригинальное название файла',
  `md5` varchar(255) DEFAULT NULL,
  `ext` varchar(255) DEFAULT NULL COMMENT 'Расширение файла',
  `mimetype` varchar(255) DEFAULT NULL COMMENT 'Тип файла',
  `size` int(11) DEFAULT NULL COMMENT 'Размер файла',
  `type_anketa` int(11) DEFAULT NULL COMMENT 'Тип файла Анкета для нового покупателя',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`kp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
 *
 *
 */
class MKpUploads extends \yii\db\ActiveRecord
{

    public $files;

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

            // обязательные поля:

            [['team_id'], 'integer'],

            [['created_at', 'updated_at', 'markdel_at'], 'string'],

            [['created_by', 'updated_by', 'markdel_by'], 'integer'],

            [['size'], 'integer'],

            [['markdel_at'], 'safe'],

            [['filename_original', 'md5', 'ext', 'mimetype'], 'string', 'max' => 255],

            [['files'], 'safe'],

            // индивидуальные поля:
            [['kp_id'], 'integer'], // - главный объект к которому привязывается файл
            [['type_anketa'], 'integer', 'max' => 1], // дополнительное поле для типа файла АНКЕТА

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'team_id' => 'Team ID',

            'created_at' => 'Добавлено когда',
            'created_by' => 'Добавлено кем',

            'updated_at' => 'Изменено когда',
            'updated_by' => 'Изменено кем',

            'markdel_by' => 'Удалено кем',
            'markdel_at' => 'Удалено когда',

            'files' => 'Выбрать файл(ы)',
            'filename_original' => 'Оригинальное название файла',
            'md5' => 'Md5',
            'ext' => 'Расширение файла',
            'mimetype' => 'Mimetype',
            'size' => 'Size',

            // дополнительные поля:
            'kp_id' => 'Kp ID', // объект, к которому прицепятся файлы
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
 
    public function getObject(){
        return $this->hasOne(Kp::className(), ['id' => 'object_id']);
    }

    public function getKp(){
        return $this->getkp();
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