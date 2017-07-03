<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%position}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Assignment[] $assignments
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%position}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['position_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\PositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PositionQuery(get_called_class());
    }
}
