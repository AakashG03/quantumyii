<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string $role_name
 * @property int $gross_package
 * @property string $role_description
 * @property string $requirements
 * @property int $created_at
 * @property int $updated_at
 *
 * @property JobRoles[] $jobRoles
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name', 'gross_package', 'role_description', 'requirements', 'created_at', 'updated_at'], 'required'],
            [['role_name', 'role_description', 'requirements'], 'string'],
            [['gross_package', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'gross_package' => 'Gross Package',
            'role_description' => 'Role Description',
            'requirements' => 'Requirements',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[JobRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobRoles()
    {
        return $this->hasMany(JobRoles::class, ['role_id' => 'id']);
    }
}
