<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "walkinjoblist".
 *
 * @property int $id
 * @property string $job_title
 * @property string $start_date
 * @property string $end_date
 * @property string $location
 * @property string|null $internship
 * @property string $general_instructions
 * @property string $exam_instructions
 * @property string $minimum_sys_req
 * @property string $process
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Hallticket[] $halltickets
 * @property JobRoles[] $jobRoles
 */
class Walkinjoblist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'walkinjoblist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_title', 'start_date', 'end_date', 'general_instructions', 'exam_instructions', 'minimum_sys_req', 'process', 'created_at', 'updated_at'], 'required'],
            [['job_title', 'location', 'internship', 'general_instructions', 'exam_instructions', 'minimum_sys_req', 'process'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_title' => 'Job Title',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'location' => 'Location',
            'internship' => 'Internship',
            'general_instructions' => 'General Instructions',
            'exam_instructions' => 'Exam Instructions',
            'minimum_sys_req' => 'Minimum Sys Req',
            'process' => 'Process',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Halltickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHalltickets()
    {
        return $this->hasMany(Hallticket::class, ['job_id' => 'id']);
    }

    /**
     * Gets query for [[JobRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobRoles()
    {
        return $this->hasMany(JobRoles::class, ['job_id' => 'id']);
    }
}
