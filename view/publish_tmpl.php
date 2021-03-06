<?php
if($_SESSION['privilege'] == PUB_AVAILABLE)
{
    $chk_available_cats = TRUE;
    $available_cats = $this->user->get_available_cats();
}
elseif($_SESSION['privilege'] == PUB_ADMIN)
{
    $chk_available_cats = FALSE;
}
else
{
    die('<div class="alert">您无权访问本页面</div>');
}

if($_GET['type'] == "edit")
{
    $article_id = is_numeric($_GET['id'])?$_GET['id']:die('<div class="alert">要修改的内容不存在</div>');
    $article = $this->mysql->query('SELECT * FROM `posts` WHERE `id` = '.$article_id.' LIMIT 1;');
    if( mysqli_num_rows($article) )
    {
        $article = mysqli_fetch_assoc($article);
    }
}
?>
<link rel="stylesheet" href="/css_loader/get/%2Fbootstrap%2Fcss%2Fbootstrap.css/%2Fcss%2Feditor.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="/static/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/static/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="/static/kindeditor/lang/zh-CN.js"></script>

<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            resizeType : 1,
            allowPreviewEmoticons : false,
            allowImageUpload : true,
            items : [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link' | 'image']
        });
    });
</script>
<body>
<?php
if($article)
{
    echo '<h2>修改修改</h2><hr><form action="/my/edit_article" method="post"><input type="hidden" name="article_id" value="'.$article_id.'">';
}
else
{
    echo '<h2>撰写新文章</h2><hr><form action="/my/pub_article" method="post">';
}
?>

    <p>
    <label for="title">文章标题</label>
    <input type="text" name="title" id="title" value="<?=$article['title']; ?>">
    </p>
    <p>
        <label for="cat">分类目录</label>
        <select name="category" id="cat">
            <?php
            $cats = $this->category->cat_list();
            foreach($cats['root'] as $root)
            {
                echo '<option value="'.$root['id'].'" disabled="disabled">'.$root['name'].'</option>';
                foreach($cats['child'][$root['id']] as $child)
                {
                    if($chk_available_cats)
                    {
                        if(!in_array($child['id'], $available_cats) and !in_array($root['id'], $available_cats)) continue;
                    }
                    $cate_id_val = $root['id'].'-'.$child['id'];
                    $current = '';
                    if($cate_id_val == $article['category'])    $current = 'selected="selected"';
                    echo '<option value="'.$cate_id_val.'" '.$current.'>&nbsp;&nbsp;&nbsp;'.$child['name'].'</option>';
                }
            }
            ?>
        </select>
    </p>
    <p>
        <label for="content">文章内容</label>
        <textarea name="content" id="content" style="height: 400px;">
            <?=$article['article_text']; ?>
        </textarea>
    </p>
    <p>
        <label>发布</label>
        <button class="btn btn-info" type="submit">立即发布</button>
        <button class="btn">保存为草稿</button>
    </p>
</form>

