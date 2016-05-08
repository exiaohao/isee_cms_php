<?php
session_start();

if($_SESSION['privilege'] == PUB_AVAILABLE)
{
    $sql = 'SELECT * FROM  `posts` WHERE `author` = '.$_SESSION['user_id'].' ORDER BY  `posts`.`pub_time` DESC ';
}
elseif($_SESSION['privilege'] == PUB_ADMIN)
{
    $sql = 'SELECT * FROM  `posts` ORDER BY  `posts`.`pub_time` DESC ';
}
else
{
    die('<div class="alert">您无权访问本页面</div>');
}
?>
<h2>已发布的</h2>
<table class="table">
    <tr>
        <th width="40">#</th>
        <th>标题</th>
        <th width="140">发布时间</th>
        <th width="50">作者</th>
        <th width="80">修改</th>
    </tr>
    <tbody>
<?php
$results = $this->mysql->query($sql);

while($item = mysqli_fetch_array($results))
{
    echo "<tr>
        <td>{$item['id']}</td>
        <td><a href='#'>{$item['title']}</a></td>
        <td>{$item['pub_time']}</td>
        <td>{$this->user->get_nick_name($item['author'])}</td>
        <td><a class='btn btn-mini btn-info' href='/my/publish?type=edit&id={$item['id']}'>修改</a> <a class='btn btn-mini btn-danger' href='#'>删除</a></td>
       </tr>";
}
?>
    </tbody>
</table>
