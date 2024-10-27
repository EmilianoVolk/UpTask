<?php 

namespace Model;

#[\AllowDynamicProperties]

class User extends ActiveRecord{
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'email', 'password', 'token', 'confirm'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->current_password = $args['current_password'] ?? '';
        $this->new_password = $args['new_password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirm = $args['confirm'] ?? 0;
    }

    //Validacion para cuentas nuevas
    public function validateNewAccount(){
        if (!$this->name) {
            self::$alertas['error'][] = 'User name is necessary';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Email is necessary';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'The Password must be at least 6 characters';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'The Passwords must be the same';
        }

        return self::$alertas;
    }

    public function validateProfile(){
        if (!$this->name) {
            self::$alertas['error'][] = 'Name is necessary';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'Email is necessary';
        }
        
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Invalid Email';
        }

        return self::$alertas;
    }

    public function validateEmail(){
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Invalid Email';
        }
        
        if (!$this->email) {
            self::$alertas['error'][] = 'Email is necessary';
        }

        return self::$alertas;
    }

    public function validateLogin(){
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Invalid Email';
        }
        
        if (!$this->email) {
            self::$alertas['error'][] = 'Email is necessary';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'Password is necesary';
        }

        return self::$alertas;
    }

    public function validateChangePasswords(){
        if (!$this->new_password) {
            self::$alertas['error'][] = 'New Password is Necesary';
        }
        if (!$this->current_password) {
            self::$alertas['error'][] = 'Current Password is necesary';
        }
        if (strlen($this->new_password) < 6) {
            self::$alertas['error'][] = 'The New Password Must be at Least 6 Characters';
        }
        if ($this->new_password === $this->current_password) {
            self::$alertas['error'][] = 'Passwords can\'t be the same';
        }

        return self::$alertas;
    }

    public function comprobateNewPassword() : bool {
        return password_verify($this->current_password, $this->password);
    }

    public function validatePasswords(){
        if (!$this->password) {
            self::$alertas['error'][] = 'Password is necesary';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'The Password must be at least 6 characters';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Passwords must be the same';
        }

        return self::$alertas;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken(){
        $this->token = uniqid();
    }
}