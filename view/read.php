<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen"-->
    <link rel="stylesheet" href="/css_loader/get/%2Fcss%2Fglobal.css/%2Fcss%2Fheader.css/%2Fbootstrap%2Fcss%2Fbootstrap.css/%2Fcss%2Fhome.css" rel="stylesheet" media="screen">
    <title><?=$argv['title']; ?> - <?=SITE_NAME; ?></title>
</head>
<body>

<div class="container">
    <div class="span4">
        <h3>相关内容</h3>
    </div>
    <div class="span6">
        <h3><?=$argv['title']; ?></h3>
        <div>
            <?=htmlspecialchars_decode($argv['article_text']); ?>
        </div>
    </div>
</div>