
<?php
$user = $this->user->get_user($argv['user_id']);
if($user) {
    $post_available = explode('|', $user['post_available']);
}
else
{
    die('<div class="alert alert-danger">错误的请求</div>');
}
?>
<h2>账号管理</h2>
<hr>
<h4>可发布分类</h4>
<form action="/my/update_user" method="post">
    <input type="hidden" name="user_id" value="<?=$argv['user_id']; ?>">
    <?php
    $cats = $this->category->cat_list();
    foreach($cats['root'] as $cat)
    {
        $current = '';
        if(in_array($cat['id'], $post_available)) $current = 'checked="checked"';
        echo '<p><label><input type="checkbox" name="post_available[]" value="'.$cat['id'].'" '.$current.' />&nbsp; '.$cat['name'].'</label></p>';
        foreach($cats['child'][$cat['id']] as $child_cat)
        {
            $current = '';
            if(in_array($child_cat['id'], $post_available)) $current = 'checked="checked"';
            echo '<p><label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post_available[]" value="'.$child_cat['id'].'" '.$current.'/>&nbsp; '.$child_cat['name'].'</label></p>';
        }
    }
    ?>
    <button type="submit" class="btn btn-info">修改</button>
</form>
<!--
<hr>
<h4>账号状态</h4>
<form action="">
    <input type="hidden" name="user_id" value="<?=$argv['user_id']; ?>">
    <label><input type="checkbox" name="" value="">&nbsp; 可用</label>
</form>
-->