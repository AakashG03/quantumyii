<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use \yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%applicant}}".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $password_reset_token
 * @property int $country_code
 * @property int $phone_number
 * @property string $resume
 * @property string $portfolio_url
 * @property string $preferred_job_roles
 * @property string|null $referral
 * @property string $job_update
 * @property int $percentage
 * @property int $passing_year
 * @property string $qualification
 * @property string $stream
 * @property string $college_name
 * @property string|null $other_college_name
 * @property string $college_location
 * @property string $applicant_type
 * @property int|null $years_exp
 * @property int|null $current_ctc
 * @property int|null $expected_ctc
 * @property string|null $tech_expert
 * @property string|null $other_tech_expert
 * @property string|null $tech_familiar
 * @property string|null $other_tech_familiar
 * @property string|null $on_notice_period
 * @property string|null $notice_period_end
 * @property string|null $notice_period_length
 * @property string $zeus_test_appeared
 * @property string|null $role_applied
 * @property int $created_at
 * @property int $updated_at
 */
class Applicant extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%applicant}}';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'country_code', 'phone_number', 'resume', 'portfolio_url', 'preferred_job_roles', 'job_update', 'percentage', 'passing_year', 'qualification', 'stream', 'college_name', 'college_location', 'applicant_type', 'zeus_test_appeared'], 'required'],
            [['first_name', 'last_name', 'preferred_job_roles', 'referral', 'job_update', 'qualification', 'stream', 'college_name', 'other_college_name', 'college_location', 'applicant_type', 'tech_expert', 'tech_familiar', 'on_notice_period', 'notice_period_end', 'notice_period_length', 'zeus_test_appeared'], 'string'],
            [['phone_number', 'country_code', 'percentage', 'passing_year', 'years_exp', 'current_ctc', 'expected_ctc', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password', 'resume', 'portfolio_url', 'other_tech_expert', 'other_tech_familiar', 'role_applied', 'password_reset_token'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 250],
            [['email'], 'unique'],
            [['phone_number'], 'unique'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'country_code' => 'Country Code',
            'phone_number' => 'Phone Number',
            'resume' => 'Resume',
            'portfolio_url' => 'Portfolio Url',
            'preferred_job_roles' => 'Preferred Job Roles',
            'referral' => 'Referral',
            'job_update' => 'Job Update',
            'percentage' => 'Percentage',
            'passing_year' => 'Passing Year',
            'qualification' => 'Qualification',
            'stream' => 'Stream',
            'college_name' => 'College Name',
            'other_college_name' => 'Other College Name',
            'college_location' => 'College Location',
            'applicant_type' => 'Applicant Type',
            'years_exp' => 'Years Exp',
            'current_ctc' => 'Current Ctc',
            'expected_ctc' => 'Expected Ctc',
            'tech_expert' => 'Tech Expert',
            'other_tech_expert' => 'Other Tech Expert',
            'tech_familiar' => 'Tech Familiar',
            'other_tech_familiar' => 'Other Tech Familiar',
            'on_notice_period' => 'On Notice Period',
            'notice_period_end' => 'Notice Period End',
            'notice_period_length' => 'Notice Period Length',
            'zeus_test_appeared' => 'Zeus Test Appeared',
            'role_applied' => 'Role Applied',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
    //......................................................register func
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
        return  $this->auth_key;
    }
    public function setHashpassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    //....................................................................
    //......................................................login func
    public function findByUsername($email)
    {
        $model = new Applicant();
        $data = $model->find(['email' => $email])->one();
        return $data;
    }
    public function validatePassword($password, $password_hash)
    {
        return Yii::$app->security->validatePassword($password, $password_hash);
    }
    //.....................................................................
    //.......................................................password reset func
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    public function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            echo "valid token";
            return null;
        }
        return static::findOne(['password_reset_token' => $token]);
    }
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    //.......................................................................................











    /**
     * {@inheritdoc}
     * @return \common\models\query\ApplicantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ApplicantQuery(get_called_class());
    }
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
