<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instructor".
 *
 * @property string $ID
 * @property string $name
 * @property string|null $dept_name
 * @property float|null $salary
 *
 * @property Advisor[] $advisors
 * @property Department $deptName
 * @property Teaches[] $teaches
 * @property Section[] $courses
 */
class Instructor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'instructor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'name'], 'required'],
            [['salary'], 'number'],
            [['ID'], 'string', 'max' => 5],
            [['name', 'dept_name'], 'string', 'max' => 20],
            [['ID'], 'unique'],
            [['dept_name'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['dept_name' => 'dept_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'dept_name' => Yii::t('app', 'Dept Name'),
            'salary' => Yii::t('app', 'Salary'),
        ];
    }

    /**
     * Gets query for [[Advisors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvisors()
    {
        return $this->hasMany(Advisor::className(), ['i_ID' => 'ID']);
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
     * Gets query for [[Teaches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeaches()
    {
        return $this->hasMany(Teaches::className(), ['ID' => 'ID']);
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Section::className(), ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year'])->viaTable('teaches', ['ID' => 'ID']);
    }
}
