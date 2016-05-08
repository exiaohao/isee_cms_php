<?php
session_start();
/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/2/7
 * Time: 上午12:58
 */
class account extends common
{
    var $ar;
    var $utils;
    function __construct($additional_request)
    {
        parent::__construct();
        $this->ar = $additional_request;
    }
    function index()
    {
        $uip = $this->utils->user_ip();
        $uhash = md5('user_login_request_'.$uip.'_'.time());
        // $this->redis->SET($uhash, $uip);
        // $this->redis->EXPIRE($uhash, TTL_LOGIN_ATTEMPT);
        $_SESSION['token'] = $uhash;
        $this->load_page('login', array('uhash'=>$uhash, 'uip'=>$uip));
    }

    function login_attempt()
    {
        if($_POST['_token'] == $_SESSION['token'])
        {
            $idcard = $_POST['username'];
            $login_attempt = $this->mysql->query('SELECT * FROM `user` WHERE `email` = \''.$idcard.'\' LIMIT 0,1;');
            if($login_attempt->num_rows > 0)
            {
                // print_r($_POST);
                $user_basic_info = $login_attempt->fetch_assoc();
                // print_r($user_basic_info);
                if($this->check_pass_hash($_POST['password'], $user_basic_info['passhash'], $user_basic_info['passsalt']))
                {
                    //login successful!
                    $user_token = 'user_login_'.$this->utils->create_uuid();
                    $_SESSION['valid'] = USER_IS_LOGIN;
                    $_SESSION['user_token'] = $user_token;
                    $_SESSION['user_name'] = $idcard;
                    $_SESSION['user_id'] = $user_basic_info['id'];
                    $_SESSION['privilege'] = $user_basic_info['privilege'];
                    //WRITE_REDIS
                    // $uip = $this->utils->user_ip();
                    // $this->redis->SET($user_token, $uip);
                    // $this->redis->EXPIRE($user_token, TTL_LOGIN_USER);
                    //
                    header('Location:/my#!/home');
                }
                else
                {
                    header('Location:/account#!/type/bad_username_or_password/0');
                }
            }
            else
            {
                header('Location:/account#!/type/bad_username_or_password/1');
            }
        }
        else
        {
            $this->global_error->bad_request($this->global_error->bad_login_attempt);
        }
    }

    /*
     * 退出账号
     * 干掉session,清redis
     */
    function logout_attempt()
    {
        foreach($_SESSION as $key=>$value)
        {
            unset($_SESSION[$key]);
        }
        header('Location:/account');
    }
}