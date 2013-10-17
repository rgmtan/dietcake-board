<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 6:49 PM
 * To change this template use File | Settings | File Templates.
 */
class User extends AppModel
{
    public $rep_password;
    public $page;

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 6, 15,
            ),
        ),
        'password' => array(
            'length' => array(
                'validate_between', 8, 15,
            ),
        ),
    );

    public function login()
    {
        if (!$this->validate()) {
            throw new ValidationException('Login information is invalid');
        }

        $db = DB::conn();
        $row = $db->row(
            'SELECT 1 FROM users WHERE username = ? AND password = ?',
            array(
                $this->username,
                md5($this->password),
            )
        );
        return $row ? true : false;
    }

    public function logout()
    {
        session_destroy();
        $this->page = 'logout';
    }

    public function register()
    {
        if (!$this->validate() || $this->isUserExisting() || $this->isPasswordMatching()) {
            throw new ValidationException('Invalid registration information');
        }

        $db = DB::conn();
        $params = array(
            "username" => $this->username,
            "password" => md5($this->password)
        );
        $db->insert("users", $params);
    }

    public function isUserExisting()
    {
        $db = DB::conn();

        $row = $db->row('SELECT 1 FROM users WHERE username = ?', array($this->username));

        return $row ? true : false;
    }

    public function isPasswordMatching()
    {
        return strcmp($this->password, $this->rep_password);
    }
}