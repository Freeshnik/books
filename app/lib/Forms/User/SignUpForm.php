<?php

namespace App\Forms\User;

use App\Model;
use App\Models\User;
use yii\db\Exception;

class SignUpForm extends Model
{
    public ?string $username = null;
    public ?string $fio = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $phone = null;
    public ?int $type = null;


    public function rules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
            [['password', 'fio', 'phone', 'type'], 'required'],
            [['password', 'fio', 'phone'], 'trim'],
            ['password', 'string', 'min' => 5],
            ['fio', 'string', 'min' => 5, 'max' => 255],
            ['type', 'in', 'range' => array_keys(User::getTypes())],
            ['phone', 'string', 'min' => 12, 'max' => 12],
            ['phone', 'match', 'pattern' => '/^\+7\d{10}$/', 'message' => 'Телефон должен быть в формате +79001005050.'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'type' => 'Тип пользователя',
        ];
    }

    /**
     * @throws Exception
     */
    public function signup(): ?bool
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->fio = $this->fio;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->type = $this->type;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->generatePasswordResetToken();

        return $user->save();
    }
}
