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
    }

    /*
     * 面板主页
     */
    function index()
    {
        //print_r($_SESSION);
        $this->load_page('my_panel', ['contanier'=>'my_home']);
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
        $this->load_page('my_panel', ['contanier'=>'publish_tmpl']);
    }
    /*
     * 新闻列表
     */
    function published()
    {
        $this->load_page('my_panel', ['contanier'=>'published_list']);
    }
    /*
     * 发布新闻
     */
    function pub_article()
    {
        $title =
    }
}