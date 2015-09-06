<?php

namespace common\modules\books\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 *
 * @property Authors $author
 */
class Book extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                //'value' => new Expression('NOW()'),
                'value' => new Expression('UTC_TIMESTAMP()'),
                'attributes' => [
                       ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                       ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'date_create', 'date_update', 'date', 'author_id'], 'required'],
            [['author_id'], 'integer'],
            [['date'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['preview'], 'string', 'max' => 200],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата обновления',
            'preview' => 'Превью',
            'date' => 'Дата выхода книги',
            'author_id' => 'ID автора',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}
