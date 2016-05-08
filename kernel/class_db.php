<?php
/*
 * db连接类
 * mysql/mongodb/redis
 */
if(!defined('IN_PAGE') || IN_PAGE != true )
{
    include 'global_error.php';
    $global_error = new global_error;
    $global_error->show_entire(404);
}

/*
 * 配置MySQL
 */
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'isee_crm');
define('MYSQL_PAWD', 'XdccaNpThVHWCNRm');
define('MYSQL_TABL', 'isee_crm');

/*
 * 配置REDIS
 */
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', 6379);

/*
 * 配置MongoDB
 */
define('MONGO_HOST', '127.0.0.1');
define('MONGO_PORT', 27017);
define('MONGO_USER', '');
define('MONGO_PASS', '');
define('MONGO_DBNM', '');

class db
{
    var $mysql;
    var $mysql_status;
    var $redis;
    var $mongo;

    function __construct()
    {
        $this->init_mysql();
        // $this->init_redis();
        // $this->init_mongo();
    }

    //Connect MySQL
    private function init_mysql()
    {
        $this->mysql = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PAWD, MYSQL_TABL) or die("SQL Error " . mysqli_error());
        $this->mysql->query("SET NAMES utf8;");
        $this->mysql_status = 1;
    }

    private function init_redis()
    {
        // $this->redis = new Redis();
        // $this->redis->connect(REDIS_HOST, REDIS_PORT);
    }

    /*
    private function init_mongo()
    {
        if(MONGO_USER != '')
            $this->mongo = new MongoClient('mongodb://'.MONGO_USER.':'.MONGO_PASS.'@'.MONGO_HOST.':'.MONGO_PORT.'/'.MONGO_DBNM);
        else
            $this->mongo = new MongoClient('mongodb://'.MONGO_HOST.':'.MONGO_PORT.'/'.MONGO_DBNM);
    }
    */
}

?>