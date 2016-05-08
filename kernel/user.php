<?php
//session_start();
/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/5/8
 * Time: 下午12:01
 */
class user extends db
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_nick_name($user_id)
    {
        if(is_numeric($user_id))
        {
            $user = $this->mysql->query('SELECT `id`,`nickname` FROM  `user` WHERE `id` ='.$user_id.' LIMIT 1');
            $user_data = mysqli_fetch_assoc($user);
            return $user_data['nickname'];
        }
        else
        {
            return NULL;
        }
    }

    public function get_available_cats()
    {
        $sql = 'SELECT  `id` ,`post_available` FROM `user` WHERE `id` = '.$_SESSION['user_id'].' LIMIT 1';
        $availables = $this->mysql->query($sql);
        if(mysqli_num_rows($availables))
        {
            $ac = mysqli_fetch_assoc($availables);
            $available_cat = explode('|', $ac['post_available']);
            foreach($available_cat as $k=>$v)
            {
                if(empty($available_cat[$k]))   unset($available_cat[$k]);
            }
            return $available_cat;
        }
        else{
            return NULL;
        }
    }

    public function get_all_users()
    {
        $sql = 'SELECT * FROM  `user`';
        $all_users = $this->mysql->query($sql);
        $users = array();
        while($u = mysqli_fetch_array($all_users))
        {
            $users[] = $u;
        }
        return $users;
    }

    public function user_privilege($pid)
    {
        switch($pid)
        {
            case 1: return '可发布';
            case 2: return '管理员';
            case 0: return '读者';
            default: return '未知';

        }
    }

    public function user_status($sid)
    {
        switch($sid)
        {
            case 0: return '<span class="label label-success">正常</span>';
            case 1: return '<span class="label label-inverse">冻结</span>';
        }
    }

    public function get_user($uid)
    {
        $sql = 'SELECT * FROM  `user` WHERE  `id` = '.$uid.' LIMIT 1;';
        $user = $this->mysql->query($sql);
        if(mysqli_num_rows($user))
            return mysqli_fetch_assoc($user);
        else
            return NULL;
    }
}