<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property string $ID
 * @property string $name
 * @property string|null $dept_name
 * @property float|null $tot_cred
 *
 * @property Advisor $advisor
 * @property Department $deptName
 * @property Takes[] $takes
 * @property Section[] $courses
 */
class Student extends Main
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['tot_cred'], 'number'],
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
            'tot_cred' => Yii::t('app', 'Tot Cred'),
        ];
    }

    /**
     * Gets query for [[Advisor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvisor()
    {
        return $this->hasOne(Advisor::className(), ['s_ID' => 'ID']);
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
     * Gets query for [[Takes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTakes()
    {
        return $this->hasMany(Takes::className(), ['ID' => 'ID']);
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Section::className(), ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year'])->viaTable('takes', ['ID' => 'ID']);
    }
}
