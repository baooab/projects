<?php
require_once("master/connect.php");

$PAGE_SIZE = 25;
$page_num = 1;
if (isset($_GET["page"]) && !empty($_GET["page"])) {
    $page_num = $_GET["page"];
}
$Page_start = ($page_num-1)*$PAGE_SIZE;

$selectSQL = "select blog_id, blog_title, blog_category from blog_posts where blog_category not in ('张宝的博客') order by blog_id desc limit $Page_start, $PAGE_SIZE";
$countSQL = "select count(*) from blog_posts where blog_category not in ('张宝的博客')";
$posts = $link->query($selectSQL);
$posts_count = ($link->query($countSQL))->fetch_row()[0];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>张宝的博客</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/pages/index.php.css" rel="stylesheet">
  </head>
  <body class="container">

      <?php require_once("master/header.php"); ?>

      <section class="row">
          <article class="col-md-9">
              <?php
              if ($posts->num_rows > 0) {
              ?>
              <ol class="list-group">
                  <li class="list-group-item list-group-item-header">博文列表（共收录博文<?php echo $posts_count ?>篇）</li>
              <?php
                 while ($row = $posts->fetch_assoc()) {
              ?>
                  <li class="list-group-item">
                      <span class="badge"><a href="/blog/blog-category.php?blog_category=<?php echo $row["blog_category"]?>"><?php echo $row["blog_category"]?></a></span><a href="blog-detail.php?blog_id=<?php echo $row["blog_id"]?>"><?php echo $row["blog_title"]?></a>
                  </li>
              <?php
                }
              ?>
                  <li class="list-group-item list-group-item-footer">
                      <ul class="pager" style="margin:0;">
                          <li class="previous"><a href="?page=<?php echo ($page_num+1)?>"><span aria-hidden="true">←</span> Older</a></li>
                          <?php
                          if ($page_num-1 > 0) {
                          ?>
                          <li class="next"><a href="?page=<?php echo ($page_num-1)?>">Newer <span aria-hidden="true">→</span></a></li>
                          <?php
                          }
                          ?>
                      </ul>
                  </li>
              </ol>
              <?php
              } else {
                 echo "No Result:(";
              }
              ?>
          </article>
<!--
          <section class="col-md-4">
              <div class="panel panel-default">
                  <div class="panel-heading">博文标签</div>
                  <div class="panel-body">
                    JavaScript(22)<br>
                    CSS(13)<br>
                  </div>
              </div>
              <div class="panel panel-default">
                  <div class="panel-heading">博文归档</div>
                  <div class="panel-body">
                      <ol class="list-unstyled">
                          <li><a href="#">March 2014(12)</a></li>
                          <li><a href="#">February 2014(2)</a></li>
                          <li><a href="#">January 2014(2)</a></li>
                          <li><a href="#">December 2013(2)</a></li>
                          <li><a href="#">November 2013(2)</a></li>
                          <li><a href="#">October 2013(2)</a></li>
                          <li><a href="#">September 2013(2)</a></li>
                          <li><a href="#">August 2013(2)</a></li>
                          <li><a href="#">July 2013(2)</a></li>
                          <li><a href="#">June 2013(2)</a></li>
                          <li><a href="#">May 2013(2)</a></li>
                          <li><a href="#">April 2013(2)</a></li>
                      </ol>
                  </div>
              </div>
              <div class="thumbnail">
                  <img alt="http://image.wufazhuce.com/Fo0FAwZqoMSorH4yBo0Qsd4odv72" src="http://image.wufazhuce.com/Fo0FAwZqoMSorH4yBo0Qsd4odv72">
                  <div class="caption">
                    <p>One night in HongKong&amp;邹瑜鹏-J神 作品 / 来自<a href="http://m.wufazhuce.com/one/1525" target="_blank">#一个#</a></p>
                  </div>
              </div>
              <div class="thumbnail">
                  <img alt="http://www.ruanyifeng.com/images_pub/pub_335.jpg" src="http://www.ruanyifeng.com/images_pub/pub_335.jpg">
                  <div class="caption">
                    来自<a target="_blank" href="http://www.ruanyifeng.com/">#阮一峰的个人网站#</a><p></p>
                  </div>
              </div>
          </section>
 -->
          <aside class="col-md-3">
              <div class="well">
                 <iframe allowtransparency="true" scrolling="no" src="//tianqi.2345.com/plugin/widget/index.htm?s=3&amp;z=1&amp;t=0&amp;v=0&amp;d=1&amp;bd=0&amp;k=000000&amp;f=&amp;q=1&amp;e=0&amp;a=1&amp;c=54511&amp;w=250&amp;h=28&amp;align=left" width="220" height="22" frameborder="0"></iframe>
              </div>
              <div class="panel panel-default hidden-xs">
                  <div class="panel-heading">参考文档</div>
                  <div class="panel-body">
                      <ol class="list-unstyled">
                          <li><a href="https://nodejs.org/dist/latest-v6.x/docs/api/all.html" target="_blank">Node.js v6.9.1 Documentation</a></li>
                          <li><a href="http://getbootstrap.com/getting-started/" target="_blank">Bootstrap (v3.3.7) - Getting started</a></li>
                      </ol>
                  </div>
              </div>
              <div class="panel panel-default hidden-xs">
                  <div class="panel-heading">外部链接</div>
                  <div class="panel-body">
                    <a target="_blank" href="http://www.ruanyifeng.com/">#阮一峰的个人网站#</a><br>
                    <a href="http://m.wufazhuce.com/one/1525" target="_blank">#一个#</a>
                  </div>
              </div>
              <div class="thumbnail hidden-xs">
                  <img alt="http://image.wufazhuce.com/Fo0FAwZqoMSorH4yBo0Qsd4odv72" src="http://image.wufazhuce.com/Fo0FAwZqoMSorH4yBo0Qsd4odv72">
                  <div class="caption">
                    <p>一页香港, by 邹瑜鹏-J神</p>
                  </div>
              </div>
          </aside>
      </section>

      <?php require_once("master/footer.php"); ?>

      <script src="js/jquery.1.12.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
  </body>
</html>