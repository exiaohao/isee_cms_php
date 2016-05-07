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
            allowImageUpload : false,
            items : [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link']
        });
    });
</script>
<body>
<h2>发布</h2>
<hr>
<form action="/my/pub_article" method="post">
    <p>
    <label for="title">标题</label>
    <input type="text" name="title" id="title">
    </p>
    <p>
        <label for="cat">分类</label>
        <select name="category" id="cat">
            <?php
            $cats = $this->category->cat_list();
            foreach($cats['root'] as $root)
            {
                echo '<option value="'.$root['id'].'">'.$root['name'].'</option>';
                foreach($cats['child'][$root['id']] as $child)
                {
                    echo '<option value="'.$root['id'].'-'.$child['id'].'">&nbsp;&nbsp;&nbsp;'.$child['name'].'</option>';
                }
            }
            ?>
        </select>
    </p>
    <p>
        <label for="content">文章内容</label>
        <textarea name="content" id="content" style="height: 400px;"></textarea>
    </p>
    <p>
        <button class="btn btn-info" type="submit">发布</button>
    </p>
</form>

