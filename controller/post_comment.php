<?php
session_start();
/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/5/15
 * Time: 下午11:26
 */
class post_comment extends common
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
        if ($_SESSION['valid'] == 1 && $_SESSION['privilege'] >= 0) {
            $text = htmlspecialchars($_POST['text']);
            $post_id = is_numeric($_POST['post_id']) ? $_POST['post_id'] : die('bad request');
            $ip_addr = $this->utils->user_ip();

            $sql = "INSERT INTO `discuss`(`post_id`, `text`, `ip_addr`, `author`) VALUES ('{$post_id}', '{$text}', '{$ip_addr}', '{$_SESSION['user_id']}');";
            $act = $this->mysql->query($sql);

            if ($act) $status = 0;
            else        $status = 1;
        } else {
            $status = 2;
        }
        header('Location:/read?id='.$_POST['post_id'].'&status='.$status.'#comment');
    }
}