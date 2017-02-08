<?php
require_once("master/connect.php");

$arr_blog_number = array();
$arr_blog_category = array();

$blog_category = null;

$posts = null;
$posts2 = null;

if (isset($_GET["blog_category"]) && !empty($_GET["blog_category"])) {
    $blog_category = $_GET["blog_category"];
}

$selectSQL = "select blog_number, blog_category from blog_tags where blog_category not in ('张宝的博客') order by blog_number desc ";
$queryBloginCategorySQL = "";

if ($blog_category != null) {
  $queryBloginCategorySQL = "select blog_id, blog_title, blog_category from blog_posts where blog_category = '$blog_category' order by blog_id desc limit 0, 80";
  $posts2 = $link->query($queryBloginCategorySQL);
}

$posts = $link->query($selectSQL);

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
  </head>
  <body class="container">

      <?php require_once("master/header.php"); ?>

      <section class="row">

          <section class="col-sm-8 <?php echo ($posts2 == null ? 'hidden-xs' : '')?>">
            <?php
              if ($posts2 !== null && $posts2->num_rows > 0) {
            ?>
              <h1>【<?php echo $blog_category?>】下的博文</h1>
              <div class="list-group">
            <?php
                while ($row2 = $posts2->fetch_assoc()) {
            ?>
                <a href="./blog-detail.php?blog_id=<?php echo $row2["blog_id"]?>" class="list-group-item"><?php echo $row2["blog_title"]?></a>
            <?php
                }
            ?>
              </div>
            <?php
              }
            ?>
          </section>

          <article class="col-sm-4">
              <?php
              if ($posts->num_rows > 0) {
              ?>
              <h1>博文标签</h1>
              <div class="list-group">
              <?php
                 while ($row = $posts->fetch_assoc()) {
                  $arr_blog_number[] = $row["blog_number"];
                  $arr_blog_category[] = $row["blog_category"];
              ?>
                <a href="./blog-category.php?blog_category=<?php echo $row["blog_category"]?>" class="list-group-item"><span class="badge"><?php echo $row["blog_number"]?></span><?php echo $row["blog_category"]?></a>
              <?php
                }
              ?>
              </div>
              <?php
              } else {
                 echo "No Result:(";
              }
              ?>
          </article>

      </section>

      <?php require_once("master/footer.php"); ?>

      <script src="js/jquery.1.12.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>

      </script>
  </body>
</html>