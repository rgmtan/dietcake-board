<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 6:49 PM
 * To change this template use File | Settings | File Templates.
 */

class UserController extends AppController
{
    public function login()
    {
        $user = new User;
        $page = Param::get('page_next', 'login');

        switch($page) {
            case 'login':
                break;
            case 'login_success':
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                try {
                    $page = $user->login();
                } catch (ValidationException $e) {
                    $page = 'login';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function register()
    {
        $user = new User;
        $page = Param::get('page_next', 'register');

        switch($page) {
            case 'register':
                break;
            case 'register_end':
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                $user->rep_password = Param::get('rep_pass');
                try {
                    $user->register();
                    $_SESSION['username'] = Param::get('username');
                } catch(ValidationException $e) {
                    $page = 'register';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function logout()
    {
        $user = new User;
        $user->logout();
        $this->set(get_defined_vars());
        $this->render($user->page);
    }
}