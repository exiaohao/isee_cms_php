<?php
/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/2/7
 * Time: 上午1:39
 */

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>注册 - <?=SITE_NAME; ?></title>
    <link rel="stylesheet" href="/css_loader/get/%2Fcss%2Fglobal.css/%2Fcss%2Fheader.css/%2Fbootstrap%2Fcss%2Fbootstrap.css" rel="stylesheet" media="screen">
  </head>
  <body>

<div class="container">
  <div class="row">
    <div class="span12">
      <h2><?=SITE_NAME; ?></h2>
      <h4>用户注册</h4>
      <hr />
    </div>
  </div>
  <div class="row">
    <div class="span6">
      <form id="registerform" action="register/do_register" method="post">
        <h4>账号信息</h4>
        <label for="email" class="pull-left">电子邮件地址</label><span class="pull-right muted">仅允许@zju.edu.cn 这将成为您的登录用户名</span>
        <input id="email" class="input-block-level" type="email" name="email" placeholder="Email">

        <label for="password" class="pull-left">密码</label><span class="pull-right muted">至少6位</span>
        <input id="password" class="input-block-level" type="password" name="password" placeholder="密码">

        <label for="repassword">确认密码</label>
        <input id="repassword" class="input-block-level" type="password" name="retype_password" placeholder="确认密码">

        <label for="realname" class="pull-left">取个名字</label>
        <input id="readname" class="input-block-level" type="text" name="realname" placeholder="你的昵称" >
        <hr />

        <hr />
        <input type="hidden" name="token" value="<?=$argv['uhash']; ?>">
        <button class="btn btn-success btn-large" type="submit" name="button">注册账号</button>
      </form>
    </div>
  </div>
</div>
<script src="static/js/jquery-1.10.2.min.js"></script>
<script src="static/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#registerform').validate({
    rules:{
      password:{
        required:true,
        minlength:6
      },
      retype_password:{
        required:true,
        minlength:6,
        equalTo:'#password'
      },
      realname:{
        required:true,
        minlength:2
      },
      email:{
        required:true,
        email:true
      },
    },
    messages:{
      password:{
        required:'请输入您的密码',
        minlength:'密码至少6位',
      },
      retype_password:{
        required:'请重新输入您的密码',
        minlength:'密码至少6位',
        equalTo: '两次输入密码不一致不一致'
      },
      realname:{
        required:'请输入您的昵称',
        minlength:'至少2个字呗亲'
      },
      email:{
        required:'请输入您的电子邮箱地址',
        email:'请输入正确的电子邮箱地址'
      },
    }
  });
});
$(function(){
  $('#email').change(function(){
    $.ajax({
      url: '/register/check_email/'+$(this).val(),
      success: function(data){
        if(data.status === 0)
        {
        }
        else {
          $('#email').val(data.msg)
        }
      },
      dataType: 'json'
    });
  })

})
</script>
