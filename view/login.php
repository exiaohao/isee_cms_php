<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css_loader/get/%2Fcss%2Fglobal.css/%2Fcss%2Fheader.css/%2Fbootstrap%2Fcss%2Fbootstrap.css" rel="stylesheet" media="screen">
    <title>用户登录 - <?=SITE_NAME; ?></title>
  </head>
  <body>

<div class="container">
  <div class="row">
    <h2><?=SITE_NAME; ?></h2>
    <h3>用户登录</h3>
  </div>
  <div class="row">
    <div class="span6">
      <div class="row">
        <div class="span4">
          <form class="" action="/account/login_attempt" method="post">
            <label for="user-login">电子邮箱地址</label>
            <input id="user-login" class="input-block-level" type="text" name="username" placeholder="电子邮箱地址">
            <label for="user-password">密码</label>
            <input id="user-password" class="input-block-level" type="password" name="password" placeholder="密码">
            <label class="checkbox"><input type="checkbox" value="remember-me">记住我的账号 </label>
            <input type="hidden" name="_token" value="<?=$argv['uhash']; ?>">
            <input type="hidden" name="_track" value="">
            <input type="hidden" name="_ref" value="<?=urldecode($_GET['ref']); ?>">
            <button class="btn btn-large btn-primary" type="submit">登录</button>
          </form>
        </div>
      </div>
    </div>
    <div class="span6">
      <h3>如果你还没有注册</h3>
      <p>
        <a class="btn btn-info" href="/register">马上注册</a>
      </p>
    </div>
  </div>
</div>
