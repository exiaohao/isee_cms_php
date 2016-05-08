<?php

/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/5/8
 * Time: 下午9:48
 */
class read extends common
{
    function index()
    {
        $id = is_numeric($_GET['id'])?$_GET['id']:header('Location:/');
        $article = mysqli_fetch_assoc($this->mysql->query("SELECT * FROM `posts` WHERE `id` = {$id} LIMIT 1;"));
        $this->load_page('read', $article);
    }
}