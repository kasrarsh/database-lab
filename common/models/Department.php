<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property string $dept_name
 * @property string|null $building
 * @property float|null $budget
 *
 * @property Course[] $courses
 * @property Instructor[] $instructors
 * @property Student[] $students
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_name'], 'required'],
            [['budget'], 'number'],
            [['dept_name'], 'string', 'max' => 20],
            [['building'], 'string', 'max' => 15],
            [['dept_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dept_name' => Yii::t('app', 'Dept Name'),
            'building' => Yii::t('app', 'Building'),
            'budget' => Yii::t('app', 'Budget'),
        ];
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['dept_name' => 'dept_name']);
    }

    /**
     * Gets query for [[Instructors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstructors()
    {
        return $this->hasMany(Instructor::className(), ['dept_name' => 'dept_name']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['dept_name' => 'dept_name']);
    }
}
