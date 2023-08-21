<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "hallticket".
 *
 * @property int $id
 * @property int $user_id
 * @property int $job_id
 * @property string $roles_applied
 * @property string $date
 * @property string $time
 * @property string $venue
 * @property int $created_at
 * @property int $updated_at
 *
 * @property JobRoles $job
 * @property Applicant $user
 */
class Hallticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hallticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'job_id', 'roles_applied', 'date', 'time', 'venue'], 'required'],
            [['user_id', 'job_id', 'created_at', 'updated_at'], 'integer'],
            [['roles_applied', 'time', 'venue'], 'string'],
            [['date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applicant::class, 'targetAttribute' => ['user_id' => 'id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobRoles::class, 'targetAttribute' => ['job_id' => 'id']],
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'job_id' => 'Job ID',
            'roles_applied' => 'Roles Applied',
            'date' => 'Date',
            'time' => 'Time',
            'venue' => 'Venue',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WalkinjoblistQuery
     */
    public function getJob()
    {
        return $this->hasOne(JobRoles::class, ['id' => 'job_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ApplicantQuery
     */
    public function getUser()
    {
        return $this->hasOne(Applicant::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\HallticketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\HallticketQuery(get_called_class());
    }
}
