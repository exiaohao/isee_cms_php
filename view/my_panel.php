<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>控制面板 - <?=SITE_NAME; ?></title>
    <link rel="stylesheet" href="/css_loader/get/%2Fbootstrap%2Fcss%2Fbootstrap.css/%2Fcss%2Feditor.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="span12">
          <h3><?=SITE_NAME; ?></h3>
          <hr />
        </div>
      </div>
      <div class="row">
        <div class="span3">
          <ul id="navi" class="nav nav-tabs nav-stacked">
            <li><a class="navi-link" id="home" href="/my/home"><img src="/static/images/world.png" alt="首页" width="15" height="15"> 首页</a></li>
            <li><a class="navi-link" id="publish" href="/my/publish"><img src="/static/images/pen.png" alt="撰写" width="15" height="15"> 撰写</a></li>
            <li><a class="navi-link" id="published" href="/my/published"><img src="/static/images/stats.png" alt="已发布的" width="15" height="15"> 已发布的</a></li>
            <li><a class="navi-link" id="published" href="/my/manager"><img src="/static/images/network.png" alt="系统管理"  width="15" height="15"> 系统管理</a></li>
            <li><a class="navi-link" id="published" href="/my/account"><img src="/static/images/contacts.png" alt="我的账号" width="15" height="15"> 我的账号</a></li>
            <li><a class="navi-link" id="published" href="/account/logout_attempt"><img src="/static/images/previous.png" alt="退出" width="15" height="15"> 退出</a></li>
          </ul>
        </div>
        <div id="main-wrapper" class="span9">
          <?php
          if(isset($argv['container']))
          {
            $this->load_page($argv['container'], $argv);
          }
          ?>
        </div>
      </div>
    </div>

<script src="/static/js/jquery-1.10.2.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>

