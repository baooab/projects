<style type="text/css">
    .zb-toolbar {
        position: fixed;
        right: 156.5px;
        bottom: 10px;
    }
    .zb-go-top {
        display: block;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #eee;
        color: #555;
        font-size: 24px;
        text-align: center;
        opacity: .7;
        line-height: 48px;
    }
    .zb-go-edit {
        display: block;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #dd514c;
        color: #fff;
        font-size: 12px;
        text-align: center;
        opacity: 1;
        line-height: 48px;
        margin-top:10px;
        transition: all .3s ease-in;
    }
    .zb-go-top:link, .zb-go-top:hover, .zb-go-top:visited,
    .zb-go-edit:link, .zb-go-edit:hover, .zb-go-edit:visited {
        text-decoration: none;
    }
    .zb-go-edit:hover {
        transform: rotate(360deg);
        color:#fff;
    }
    .zb-go-top::before {
        content: "↑";
    }
    .zb-go-edit::before {
        content: "编辑";
    }
</style>

<div class="zb-toolbar hidden-xs">
   <a title="回到顶部" class="zb-go-top" href="#"></a>
   <a title="编辑文章" class="zb-go-edit" href="blog-write.php?blog_id=<?php echo $blog_id ?>" style="display:none;"></a>
</div>