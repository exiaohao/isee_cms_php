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

class db extends sqlsafe
{
    var $mysql;
    var $redis;
    var $mongo;

    function __construct()
    {
        $this->init_mysql();
        $this->init_redis();
        //$this->init_mongo();
    }

    //Connect MySQL
    function init_mysql()
    {
        $this->mysql = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PAWD, MYSQL_TABL) or die("SQL Error " . mysqli_error());
        $this->mysql->query("SET NAMES utf8;");
    }

    function init_redis()
    {
        $this->redis = new Redis();
        $this->redis->connect(REDIS_HOST, REDIS_PORT);
    }

    /*
    function init_mongo()
    {
        if(MONGO_USER != '')
            $this->mongo = new MongoClient('mongodb://'.MONGO_USER.':'.MONGO_PASS.'@'.MONGO_HOST.':'.MONGO_PORT.'/'.MONGO_DBNM);
        else
            $this->mongo = new MongoClient('mongodb://'.MONGO_HOST.':'.MONGO_PORT.'/'.MONGO_DBNM);
    }
    */
}

class sqlsafe {
    private $getfilter = "'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    private $postfilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    private $cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    /**
     * 构造函数
     */
    public function __construct() {
        foreach($_GET as $key=>$value){$this->stopattack($key,$value,$this->getfilter);}
        foreach($_POST as $key=>$value){$this->stopattack($key,$value,$this->postfilter);}
        foreach($_COOKIE as $key=>$value){$this->stopattack($key,$value,$this->cookiefilter);}
    }
    public function check_post($value)
    {

    }
    /**
     * 参数检查并写日志
     */
    public function stopattack($StrFiltKey, $StrFiltValue, $ArrFiltReq){
        if(is_array($StrFiltValue))$StrFiltValue = implode($StrFiltValue);
        if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue) == 1){
            return TRUE;
        }
        return FALSE;
    }
    /**
     * SQL注入日志
     */
    public function writeslog($log){
        $log_path = CACHE_PATH.'logs'.DIRECTORY_SEPARATOR.'sql_log.txt';
        $ts = fopen($log_path,"a+");
        fputs($ts,$log."\r\n");
        fclose($ts);
    }
}
?>