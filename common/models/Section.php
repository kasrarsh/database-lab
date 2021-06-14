<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property string $course_id
 * @property string $sec_id
 * @property string $semester
 * @property float $year
 * @property string|null $building
 * @property string|null $room_number
 * @property string|null $time_slot_id
 *
 * @property Course $course
 * @property Classroom $building0
 * @property Takes[] $takes
 * @property Student[] $iDs
 * @property Teaches[] $teaches
 * @property Instructor[] $iDs0
 */
class Section extends Main
{
    public $classroom;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'semester', 'year'], 'required'],
            [['year'], 'number'],
            [['course_id', 'sec_id'], 'string', 'max' => 8],
            [['semester'], 'string', 'max' => 6],
            [['building'], 'string', 'max' => 15],
            [['room_number'], 'string', 'max' => 7],
            [['time_slot_id'], 'string', 'max' => 4],
            [['course_id', 'sec_id', 'semester', 'year'], 'unique', 'targetAttribute' => ['course_id', 'sec_id', 'semester', 'year']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
            [['building', 'room_number'], 'exist', 'skipOnError' => true, 'targetClass' => Classroom::className(), 'targetAttribute' => ['building' => 'building', 'room_number' => 'room_number']],
            ['classroom','safe']
        ];
    }


    public function beforeSave($insert)
    {
         parent::beforeSave($insert);
        if ($this->isNewRecord) {
            $this->sec_id = Yii::$app->security->generateRandomString(8);
        }
        return true;
    }


    public static function getSemesters(){
        return['Fall'=>'Fall','Spring'=>'Spring','Summer'=>'Summer','Winter'=>'Winter'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'course_id' => Yii::t('app', 'Course ID'),
            'sec_id' => Yii::t('app', 'Sec ID'),
            'semester' => Yii::t('app', 'Semester'),
            'year' => Yii::t('app', 'Year'),
            'building' => Yii::t('app', 'Building'),
            'room_number' => Yii::t('app', 'Room Number'),
            'time_slot_id' => Yii::t('app', 'Time Slot ID'),
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
     * Gets query for [[Building0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding0()
    {
        return $this->hasOne(Classroom::className(), ['building' => 'building', 'room_number' => 'room_number']);
    }

    /**
     * Gets query for [[Takes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTakes()
    {
        return $this->hasMany(Takes::className(), ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year']);
    }

    /**
     * Gets query for [[IDs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIDs()
    {
        return $this->hasMany(Student::className(), ['ID' => 'ID'])->viaTable('takes', ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year']);
    }

    /**
     * Gets query for [[Teaches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeaches()
    {
        return $this->hasMany(Teaches::className(), ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year']);
    }

    /**
     * Gets query for [[IDs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIDs0()
    {
        return $this->hasMany(Instructor::className(), ['ID' => 'ID'])->viaTable('teaches', ['course_id' => 'course_id', 'sec_id' => 'sec_id', 'semester' => 'semester', 'year' => 'year']);
    }
}
