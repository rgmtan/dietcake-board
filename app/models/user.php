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
    public $user_exists;
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
        if(!$this->validate()) {
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

        if($row) {
            $_SESSION['username'] = $this->username;
            return $this->page = 'login_success';
        }
        else {
            return $this->page = 'login_failed';
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->page = 'logout';
    }

    public function register()
    {
        $this->userExists();
        $this->passwordMatch();
        if(!$this->validate() || $this->user_exists || !$this->rep_password) {
            throw new ValidationException('Invalid registration information');
        }

        $db = DB::conn();
        $db->query('INSERT INTO users SET username = ?, password = ?',
            array($this->username, md5($this->password))
        );

    }

    public function userExists()
    {
        $db = DB::conn();

        $row = $db->row('SELECT 1 FROM users WHERE username = ?', array($this->username));

        if($row) {
            return $this->user_exists = true;
        }
        else {
            return $this->user_exists = false;
        }
    }

    public function passwordMatch()
    {
        if (!strcmp($this->password, $this->rep_password)) {
            return $this->rep_password = true;
        }
        else {
            return $this->rep_password = false;
        }
    }
}