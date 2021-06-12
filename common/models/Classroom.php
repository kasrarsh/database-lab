<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "classroom".
 *
 * @property string $building
 * @property string $room_number
 * @property float|null $capacity
 *
 * @property Section[] $sections
 */
class Classroom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classroom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['building', 'room_number'], 'required'],
            [['capacity'], 'number'],
            [['building'], 'string', 'max' => 15],
            [['room_number'], 'string', 'max' => 7],
            [['building', 'room_number'], 'unique', 'targetAttribute' => ['building', 'room_number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'building' => Yii::t('app', 'Building'),
            'room_number' => Yii::t('app', 'Room Number'),
            'capacity' => Yii::t('app', 'Capacity'),
        ];
    }

    /**
     * Gets query for [[Sections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['building' => 'building', 'room_number' => 'room_number']);
    }
}
