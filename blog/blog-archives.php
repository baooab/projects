<?php
require_once("master/connect.php");

$selectSQL = "select blog_month, blog_number from blog_archives order by blog_month desc";
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
          <article class="col-sm-3">
              <?php
              if ($posts->num_rows > 0) {
              ?>
              <h1>博文归档</h1>
              <div class="list-group">
              <?php
                 while ($row = $posts->fetch_assoc()) {
                  $arr_blog_number[] = $row["blog_number"];
                  $arr_blog_category[] = $row["blog_month"];
              ?>
                <a href="#" class="list-group-item"><span class="badge"><?php echo $row["blog_number"]?></span><?php echo $row["blog_month"]?></a>
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

  </body>
</html>