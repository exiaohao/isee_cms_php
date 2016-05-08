<?php
session_start();
/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/2/6
 * Time: 下午8:51
 */

define('DEBUG', true);
//DEFAULT_HOMEPAGE
define('DEFAULT_HOMEPAGE', 'welcome');
//SITE_NAME
define('SITE_NAME', '浙江大学 共享信电');
//TTL_LOGINATTEMPT
define('TTL_LOGIN_ATTEMPT', 90);
//TTL_REGISTER_ATTEMPT
define('TTL_REGISTER_ATTEMPT', 1200);
//TTL_REGISTER_CHECK_IDCARD_FREQUENCY
define('TTL_REGISTER_CHK_IDCARD', 15);
//FREQ_REGISTER_CHK_IDCARD
define('FREQ_REGISTER_CHK_IDCARD', 4);
//TTL_LOGIN_USER
define('TTL_LOGIN_USER', 3600);
//SITE_URL
define('SITE_URL', 'http://192.168.3.10:8801');
//STANDARD_USER
define('STANDARD_USER', 0);
//PUB_AVAILABLE
define('PUB_AVAILABLE', 1);
//ADMIN
define('PUB_ADMIN', 2);
//
define('USER_IS_LOGIN', 1);
//HOMEPAGE PAGINATE
define('NEWS_PER_PAGE', 10);


require 'class_db.php';
require 'utils.php';
require 'category.php';
require 'user.php';

class common extends db
{
    var $global_error;
    var $utils;
    var $category;
    var $user;
    function __construct()
    {
        parent::__construct();
        $this->global_error = $this->callClass('global_error');
        $this->utils = $this->callClass('utils');
        $this->category = $this->callClass('category');
        $this->user = $this->callClass('user');
    }
    /*
     * Call Class
     */
    function callClass($class_to_call)
    {
        return new $class_to_call();
    }
    /*
     * Load Page From '/view/{$page}.php'
     */
    function load_page($page, $argv = array())
    {
        if(empty($page))
        {
            $this->global_error->show_entire(404);
        }
        else {
            $page_path = __DIR__ . "/../view/{$page}.php";
            $fp = fopen($page_path, 'r');
            if ($fp) {
                require $page_path;
            } else {
                $this->global_error->show_entire(404);
            }
        }
    }
    /*
     * 创建密码hash
     * 方法 md5(password+salt)
     */
    function creat_pass_hash($pass, $salt = '')
    {
        return md5($pass.$salt);
    }
    /*
     * 检查密码
     */
    function check_pass_hash($pass_origin, $passhash, $salt)
    {
//        print_r($pass_origin);
//        print_r($passhash);
//        print_r($salt);
        if( md5($pass_origin.$salt) == $passhash ) return true;
        else return false;
    }
    /*
     * 检查某用户的密码
     */
    function check_user_pass_hash($pass_origin, $uid)
    {
        $user = $this->user->get_user($uid);
        return $this->check_pass_hash($pass_origin, $user['passhash'], $user['passsalt']);
    }
    /*
     * 检查用户已经登录?
     * 登录了返回用户信息
     */
    function is_loggedin()
    {
        if ($_SESSION['valid'] == USER_IS_LOGIN)
        {
            //if($this->redis->TTL($_SESSION['user_token']) > 0 && $_SESSION['user_id'] > 0)
            //{
                $user_info = $this->mysql->query('SELECT * FROM `student_basicinfo` WHERE  `id` = '.$_SESSION['user_id'].' LIMIT 0,1;');
                if($user_info->num_rows > 0)
                    return $user_info->fetch_assoc();
                else {
                    unset($_SESSION['valid']);
                    return false;
                }
            //}
            //else {
            //    unset($_SESSION['valid']);
            //    return false;
            //}
        }
    }
}