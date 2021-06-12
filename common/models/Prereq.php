<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prereq".
 *
 * @property string $course_id
 * @property string $prereq_id
 *
 * @property Course $course
 * @property Course $prereq
 */
class Prereq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prereq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'prereq_id'], 'required'],
            [['course_id', 'prereq_id'], 'string', 'max' => 8],
            [['course_id', 'prereq_id'], 'unique', 'targetAttribute' => ['course_id', 'prereq_id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
            [['prereq_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['prereq_id' => 'course_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'course_id' => Yii::t('app', 'Course ID'),
            'prereq_id' => Yii::t('app', 'Prereq ID'),
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }

    /**
     * Gets query for [[Prereq]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrereq()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'prereq_id']);
    }
}
