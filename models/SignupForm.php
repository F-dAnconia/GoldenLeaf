<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $surname;
    public $email;
    public $birth_date;
    public $phone;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['surname', 'trim'],
            ['surname', 'required'],
            ['surname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['birth_date', 'required'],
            ['birth_date', 'string'],

            ['phone', 'required'],
            //TODO Повозиться с регуляркой чтоб адекватный формат телефона был
//            ['phone', 'match', 'pattern' => '/^\+38\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/', 'message' => 'Invalid phone number.'], //+38(063)730=36-90
            ['phone', 'match', 'pattern' => '/^\d{10}$/', 'message' => 'Invalid phone number, example 0637303690'], //0637303690

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->surname = $this->surname;
        $user->email = $this->email;
        $user->birth_date = $this->birth_date;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
