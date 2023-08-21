<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "job_roles".
 *
 * @property int $id
 * @property int $job_id
 * @property int $role_id
 * @property int $created_at
 * @property int $updated_at
 */
class JobRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_id', 'role_id'], 'required'],
            [['job_id', 'role_id', 'created_at', 'updated_at'], 'integer'],
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
            'job_id' => 'Job ID',
            'role_id' => 'Role ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\JobrolesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\JobrolesQuery(get_called_class());
    }
}
