<?php
$user = $this->user->get_user($_SESSION['user_id']);
?>
<h2>我的账号</h2>
<hr>
<form action="/my/update_account" method="post">
    <h5>显示名称</h5>
    <p>
        <label>显示名称: <input type="text" name="nickname" value="<?=$user['nickname']; ?>"></label>
    </p>
    <hr>
    <h5>修改密码</h5>
    <p>
        <label>旧密码: <input type="text" name="current_pass"></label>
    </p>
    <p>
        <label>新密码: <input type="text" name="new_pass"></label>
    </p>
    <p>
        <label>重复 新密码: <input type="text" name="retype_new_pass"></label>
    </p>
    <p class="muted">不修改密码则留空</p>
    <hr>
    <p><button class="btn btn-info" type="submit">保存修改</button></p>
</form>