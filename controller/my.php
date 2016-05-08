<?php
session_start();
/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/2/15
 * Time: 下午7:46
 */
class my extends common
{
    var $ar;
    function __construct($additional_request)
    {
        parent::__construct();
        $this->ar = $additional_request;

        if($_SESSION['valid'] != USER_IS_LOGIN)
        {
            header('Location:/account');
            exit();
        }
        if(isset($_GET['status']))
        {
            if($_GET['status'] == 1)
            {
                echo '<div class="alert alert-success">您的操作已完成</div>';
            }
            if($_GET['status'] == 0)
            {
                echo '<div class="alert alert-danger">您的操作发生问题</div>';
            }
            if($_GET['status'] == 3)
            {
                echo '<div class="alert alert-danger">非法操作</div>';
            }
            if($_GET['status'] == 4)
            {
                echo '<div class="alert alert-danger">新密码不一致</div>';
            }
            if($_GET['status'] == 5)
            {
                echo '<div class="alert alert-danger">当前密码错误</div>';
            }
        }
    }

    /*
     * 面板主页
     */
    function index()
    {
        //print_r($_SESSION);
        $this->load_page('my_panel', ['container'=>'my_home']);
    }
    /*
     * 默认页面
     */
    function home()
    {
        $this->index();
    }
    /*
     * 发布新闻页面
     */
    function publish()
    {
        $this->load_page('my_panel', ['container'=>'publish_tmpl']);
    }
    /*
     * 新闻列表
     */
    function published()
    {
        $this->load_page('my_panel', ['container'=>'published_list']);
    }
    /*
     * 系统管理
     */
    function manager()
    {
        $this->load_page('my_panel', ['container'=>'manager']);
    }
    /*
     *
     */
    function edit_user()
    {
        $this->load_page('my_panel', ['container'=>'edit_user', 'user_id'=>$this->ar[0]]);
    }
    /*
     * 修改账号
     */
    function account()
    {
        $this->load_page('my_panel', ['container'=>'edit_account']);
    }
    /*
     * 发布新闻
     */
    function pub_article()
    {
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
        $category = $_POST['category'];
        $article = htmlspecialchars($_POST['content'], ENT_QUOTES);
        $author = $_SESSION['user_id'];

        $sql = "INSERT INTO `posts`(`title`, `category`, `author`, `article_text`)
              VALUES ('{$title}', '{$category}', '{$author}', '{$article}');";

        var_dump($this->mysql->mysql_status);
        $action = $this->mysql->query($sql);
        if($action)
        {
            header('Location:/my/home?status=1');
        }
        else
        {
            header('Location:/my/home?status=0');
        }
    }
    /*
     * 修改新闻
     */
    function edit_article()
    {
        $article_id = is_numeric($_POST['article_id']) ? $_POST['article_id'] : $this->global_error->show_entire(502);
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
        $category = $_POST['category'];
        $article = htmlspecialchars($_POST['content'], ENT_QUOTES);
        $article = $this->mysql->query('UPDATE `posts` SET `title`=\'' . $title . '\',`category`=\'' . $category . '\',`article_text`=\'' . $article . '\' WHERE `id`= ' . $article_id);
        if ($article) {
            header('Location:/my/published?status=1');
        } else {
            header('Location:/my/published?status=0');
        }
    }
    /*
     * 修改账号可编辑分类
     */
    function update_user()
    {
        if($_SESSION['privilege'] == 2)
        {
            $user_id = is_numeric($_POST['user_id'])?$_POST['user_id']:die('bad request');
            $cats_list = '';
            foreach($_POST['post_available'] as $cat) {
                $cats_list .= $cat;
                $cats_list .= '|';
            }
            $sql = 'UPDATE `user` SET `post_available`=\''.$cats_list.'\' WHERE `id` = '.$user_id.' LIMIT 1';
            $action = $this->mysql->query($sql);
            if($action)
            {
                header('Location:/my/manager?status=1');
            } else {
                header('Location:/my/manager?status=0');
            }

        }
        else
        {
            header('Location:/my/home?status=3');
        }
    }
    /*
     * 更新账号
     */
    function update_account()
    {
        print_r($_POST);
        if(!empty($_POST['current_pass']))
        {
            //edit password
            if($_POST['new_pass'] == $_POST['retype_new_pass'])
            {
                if($this->check_user_pass_hash($_POST['current_pass'], $_SESSION['user_id']))
                {
                    $pass_salt = substr(md5(time()), 0, 6);
                    $new_pass_hash = $this->creat_pass_hash($_POST['new_pass'], $pass_salt);
                    $sql = 'UPDATE `user` SET `passhash`=\''.$new_pass_hash.'\',`passsalt`= \''.$pass_salt.'\' WHERE `id` = '.$_SESSION['user_id'].' LIMIT 1';
                    $action = $this->mysql->query($sql);
                    if($action)
                    {
                        header('Location:/my/account?status=1');
                    }
                    else
                    {
                        header('Location:/my/account?status=0');
                    }
                }
                else
                {
                    header('Location:/my/account?status=5');
                }
            }
            else
            {
                header('Location:/my/account?status=4');
            }
        }
        else
        {
            //update nickname
            $sql = '';
        }
    }
}