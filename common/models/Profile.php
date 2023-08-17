<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property int $profile_id
 * @property int $user_id
 * @property string $firstname
 * @property string $lastname
 * @property int $remember_me
 * @property int $country_code
 * @property int $phone_number
 * @property string $resume_doc
 * @property string $portfolio_url
 * @property string $preferred_job_roles
 * @property string $employee_referral_name
 * @property int $send_job_updates
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'firstname', 'lastname', 'remember_me', 'country_code', 'phone_number', 'resume_doc', 'portfolio_url', 'preferred_job_roles', 'employee_referral_name', 'send_job_updates'], 'required'],
            [['user_id', 'country_code', 'phone_number'], 'integer'],
            [['preferred_job_roles', 'employee_referral_name', 'send_job_updates', 'remember_me'], 'string'],
            [['firstname', 'lastname'], 'string', 'max' => 250],
            [['resume_doc', 'portfolio_url'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'remember_me' => 'Remember Me',
            'country_code' => 'Country Code',
            'phone_number' => 'Phone Number',
            'resume_doc' => 'Resume Doc',
            'portfolio_url' => 'Portfolio Url',
            'preferred_job_roles' => 'Preferred Job Roles',
            'employee_referral_name' => 'Employee Referral Name',
            'send_job_updates' => 'Send Job Updates',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProfileQuery(get_called_class());
    }
}
