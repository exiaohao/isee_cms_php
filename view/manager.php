<?php
session_start();
if($_SESSION['privilege'] == PUB_ADMIN)
{
}
else
{
    die('<div class="alert">您无权访问本页面</div>');
}

?>
<h2>系统管理</h2>
<hr>

<h4>用户配置</h4>
<table class="table">
    <tr>
        <th width="30">#</th>
        <th>用户名</th>
        <th>显示名</th>
        <th width="50">权限</th>
        <th width="50">状态</th>
        <th width="70">可发布分类</th>
        <th width="50">编辑</th>
    </tr>
    <tbody>
<?php
$users = $this->user->get_all_users();
foreach($users as $user)
{
    if($user['privilege'] == 2)
        $post_available = '所有';
    else{
        if(isset($user['post_available']))
        {
            $post_available = '部分';
        }
        else
        {
            $post_available = '-';
        }
    }

    echo '<tr>
    <td>'.$user['id'].'</td>
    <td>'.$user['email'].'</td>
    <td>'.$user['nickname'].'</td>
    <td>'.$this->user->user_privilege($user['privilege']).'</td>
    <td>'.$this->user->user_status($user['status']).'</td>
    <td>'.$post_available.'</td>
    <td><a class="btn btn-mini btn-info" href="/my/edit_user/'.$user['id'].'">修改</a></td>
</tr>';
}
?>
    </tbody>
</table>
