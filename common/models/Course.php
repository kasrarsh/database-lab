<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property string $course_id
 * @property string|null $title
 * @property string|null $dept_name
 * @property float|null $credits
 *
 * @property Department $deptName
 * @property Prereq[] $prereqs
 * @property Prereq[] $prereqs0
 * @property Course[] $prereqs1
 * @property Course[] $courses
 * @property Section[] $sections
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id'], 'required'],
            [['credits'], 'number'],
            [['course_id'], 'string', 'max' => 8],
            [['title'], 'string', 'max' => 50],
            [['dept_name'], 'string', 'max' => 20],
            [['course_id'], 'unique'],
            [['dept_name'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['dept_name' => 'dept_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'course_id' => Yii::t('app', 'Course ID'),
            'title' => Yii::t('app', 'Title'),
            'dept_name' => Yii::t('app', 'Dept Name'),
            'credits' => Yii::t('app', 'Credits'),
        ];
    }

    /**
     * Gets query for [[DeptName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeptName()
    {
        return $this->hasOne(Department::className(), ['dept_name' => 'dept_name']);
    }

    /**
     * Gets query for [[Prereqs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrereqs()
    {
        return $this->hasMany(Prereq::className(), ['course_id' => 'course_id']);
    }

    /**
     * Gets query for [[Prereqs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrereqs0()
    {
        return $this->hasMany(Prereq::className(), ['prereq_id' => 'course_id']);
    }

    /**
     * Gets query for [[Prereqs1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrereqs1()
    {
        return $this->hasMany(Course::className(), ['course_id' => 'prereq_id'])->viaTable('prereq', ['course_id' => 'course_id']);
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['course_id' => 'course_id'])->viaTable('prereq', ['prereq_id' => 'course_id']);
    }

    /**
     * Gets query for [[Sections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['course_id' => 'course_id']);
    }
}
