<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teaches".
 *
 * @property string $ID
 * @property string $course_id
 * @property string $sec_id
 * @property string $semester
 * @property float $year
 *
 * @property Section $section
 * @property Instructor $iD
 */
class Teaches extends Main
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teaches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'course_id', 'sec_id', 'semester', 'year'], 'required'],
            [['year'], 'number'],
            [['ID'], 'string', 'max' => 5],
            [['course_id', 'sec_id'], 'string', 'max' => 8],
            [['semester'], 'string', 'max' => 6],
            [['ID', 'course_id', 'sec_id', 'semester', 'year'], 'unique', 'targetAttribute' => ['ID', 'course_id', 'sec_id', 'semester', 'year']],
            [['course_id', 'sec_id', 'semester', 'year'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year']],
            [['ID'], 'exist', 'skipOnError' => true, 'targetClass' => Instructor::className(), 'targetAttribute' => ['ID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'sec_id' => Yii::t('app', 'Sec ID'),
            'semester' => Yii::t('app', 'Semester'),
            'year' => Yii::t('app', 'Year'),
        ];
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year']);
    }

    /**
     * Gets query for [[ID]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getID()
    {
        return $this->hasOne(Instructor::className(), ['ID' => 'ID']);
    }
}
