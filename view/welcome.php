<?php
/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/2/6
 */

?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen"-->
    <link rel="stylesheet" href="/css_loader/get/%2Fcss%2Fglobal.css/%2Fcss%2Fheader.css/%2Fbootstrap%2Fcss%2Fbootstrap.css/%2Fcss%2Fhome.css" rel="stylesheet" media="screen">
    <title>首页 - <?=SITE_NAME; ?></title>
</head>
<body>


<div class="navbar-wrapper">
    <div class="container">

        <div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="#"><?=SITE_NAME; ?></a>
                <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">
                        <li class="active"><a href="#">首页</a></li>
                        <?php
                        if(!empty($argv['username']))
                        {
                          echo '<li><a href="javascript:;">欢迎,'.$argv['username'].'</a></li>
                          <a class="btn btn-info" href="/my#!/home">控制面板</a>
                          <a class="btn btn-warning" href="/account/logout">退出</a>';
                        }
                        else {
                          echo '<a class="btn btn-success" href="/register">注册</a>
                          <a class="btn btn-info" href="/account">登录</a>';
                        }
                        ?>

                    </ul>
                </div><!--/.nav-collapse -->
            </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->

    </div> <!-- /.container -->
</div><!-- /.navbar-wrapper -->
<!--Slider-->
<div id="myCarousel" class="carousel slide">
    <div class="carousel-inner">
        <div class="item active">
            <img src="http://v2.bootcss.com/assets/img/examples/slide-01.jpg" alt="">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Example headline.</h1>
                    <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <a class="btn btn-large btn-primary" href="#">Sign up today</a>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="http://v2.bootcss.com/assets/img/examples/slide-02.jpg" alt="">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Another example headline.</h1>
                    <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <a class="btn btn-large btn-primary" href="#">Learn more</a>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="http://v2.bootcss.com/assets/img/examples/slide-03.jpg" alt="">
            <div class="container">
                <div class="carousel-caption">
                    <h1>One more for good measure.</h1>
                    <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <a class="btn btn-large btn-primary" href="#">Browse gallery</a>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>

<div class="container">
    <div class="span4">
        <h3>组织结构</h3>
        <div>
            <?php
            $cats = $this->category->cat_list();
            foreach ($cats['root'] as $cat) {
                echo '<p class="header-cat">'.$cat['name'].'</p>';
                foreach($cats['child'][$cat['id']] as $child)
                {
                    echo '<p class="child-cat"><a href="/category?id='.$child['id'].'">'.$child['name'].'</a></p>';
                }
            }

            ?>
        </div>
    </div>
    <div class="span6">
        <h3>最新信息</h3>
        <div>
            <?php
            $lines = mysqli_num_rows($this->mysql->query('SELECT * FROM  `posts` WHERE `status` >= 0 AND `is_hidden` = 0'));
            $curr_page = is_numeric($_GET['page'])?($_GET['page'] + 0):0;

            $start_page = $curr_page * NEWS_PER_PAGE;
            $get_news = $this->mysql->query('SELECT * FROM  `posts` WHERE `status` >= 0 AND `is_hidden` = 0 ORDER by `pub_time` DESC LIMIT '.$start_page.','.NEWS_PER_PAGE);
            while($news = mysqli_fetch_array($get_news))
            {
                echo '
                <div class="news-node">
                    <p class="news-header"><a href="/read?id='.$news['id'].'">'.$news['title'].'</a></p>
                    <div class="overview">'.mb_substr(strip_tags(htmlspecialchars_decode($news['article_text'])), 0, 100, 'utf-8').'...</div>
                    <p class="info">发布于 '.$news['pub_time'].'  浏览'.$news['read_count'].'  评论0</p>
                </div>

                ';
            }
            ?>
        </div>
    </div>

    <div class="span12">
        <hr />
        <footer>
            <p>@ Copyright <?=date(Y); ?> - <?=SITE_NAME; ?></p>
        </footer>
    </div>
</div>


<script src="/static/js/jquery-1.10.2.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script>
    !function ($) {
        $(function(){
            // carousel demo
            $('#myCarousel').carousel()
        })
    }(window.jQuery)
</script>
