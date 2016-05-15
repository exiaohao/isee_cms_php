<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen"-->
    <link rel="stylesheet" href="/css_loader/get/%2Fcss%2Fglobal.css/%2Fcss%2Fheader.css/%2Fbootstrap%2Fcss%2Fbootstrap.css/%2Fcss%2Fhome.css/%2Fcss%2Freader.css" rel="stylesheet" media="screen">
    <title><?=$argv['title']; ?> - <?=SITE_NAME; ?></title>
</head>
<body>

<div class="container">
    <div class="span12" id="header">
        <h3><?=SITE_NAME; ?></h3>
    </div>
    <div class="span3">
        <h4>相关内容</h4>
        <?php
        $related_id = explode('-', $argv['category']);
        $related_sql = $this->mysql->query("SELECT * FROM `posts` WHERE `category` LIKE '%{$related_id[0]}-%' AND `id` != {$argv['id']} ORDER by `pub_time` DESC LIMIT 5");
        while($ritem = mysqli_fetch_array($related_sql))
        {
            echo "<p class='related'>
<span class='muted'>{$ritem['pub_time']}</span><br />
<a href='/read?id={$ritem['id']}'>{$ritem['title']}</a>
</p>";
        }

        ?>
    </div>
    <div class="span8">
        <h3><?=$argv['title']; ?></h3>
        <p class="pub-info">发布于: <?=$argv['pub_time']; ?>, 作者:<?=$this->user->get_nick_name($argv['author']); ?>,
        阅读:<?=($argv['read_count']+1); ?></p>
        <div>
            <?=htmlspecialchars_decode($argv['article_text']); ?>
        </div>
        <hr>
        <?php
        if($_SESSION['valid']) {
            ?>
            <div class="discuss">
                <a name="comment"></a>
                <h5>评论</h5>
                <?php
                $comments = $this->mysql->query('SELECT * FROM `discuss` WHERE `post_id` ORDER BY `discuss`.`time` DESC;');
                while($cm_item = mysqli_fetch_array($comments))
                {
                    $author = $this->user->get_nick_name($cm_item['author']);
                    echo "<p class='comment-line'><strong>{$author}</strong> : {$cm_item['text']} <br /><span>{$cm_item['time']}</span></p>";
                }
                ?>
                <form action="/post_comment" method="post">
                    <input type="hidden" name="post_id" value="<?=$argv['id']; ?>">
                    <label>评论内容</label>
                <textarea name="text"></textarea>
                    <p>
                        <button type="submit" class="btn btn-info">发布</button> <span class="muted">(由<?=$this->user->get_nick_name($_SESSION['user_id']); ?>发布)</span>
                        <a href="/account/logout_attempt">换一个账户</a>
                    </p>
                </form>
            </div>
            <?php
        }
        else{
            $ref_url = urlencode('/read?id='.$argv['id']);
            echo "<p>要发表评论,请先<a href='/register'>注册</a>或<a href='/account?ref={$ref_url}'>登录</a></p>";
        }
        ?>
    </div>
    <div class="span12">
        <hr />
        <footer>
            <p>@ Copyright <?=date(Y); ?> - <?=SITE_NAME; ?></p>
        </footer>
    </div>
</div>