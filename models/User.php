<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $password
 * @property string $date_of_birth
 * @property string $tel
 * @property int $role_id
 *
 * @property Reception[] $receptions
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function __toString()
    {
        return $this->fio;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'password', 'date_of_birth', 'tel', 'role_id'], 'required'],
            [['date_of_birth'], 'safe'],
            [['role_id'], 'integer'],
            [['fio'], 'string', 'max' => 511],
            [['password', 'tel'], 'string','max' => 255],
            [['password'], 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', 'message'=>'Пароль должен содержать содержать хотя бы одну цифру, латинскую букву и быть длиннее 8-ми символов'],
            [['tel'], 'unique', 'message' =>'Номер телефона уже зарегистрирован'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'password' => 'Пароль',
            'password_confirmation' => 'Повторите пароль',
            'date_of_birth' => 'Дата рождения',
            'tel' => 'Телефон',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * Gets query for [[Receptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceptions()
    {
        return $this->hasMany(Reception::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public static function vhod($tel,$password){
        $user = static::find()->where(['Tel' => $tel])->one();
        if ($user && $user->validatePassword($password)) {
            return $user;
        }
        return null;
    }

    public function validatePassword($password){
        return $this->password === $password;
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id'=>$id])->one();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function isAdmin() {
        return $this->role_id == Role::ADMIN_ROLE_ID;
    }

    /**
     * @return User|null
     */

    public static function getInstance() {
        return Yii::$app->user->identity;
    }
}
