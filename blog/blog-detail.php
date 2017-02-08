<?php
require_once("master/connect.php");

if (isset($_GET["blog_id"]) ) {
    $blog_id = $_GET["blog_id"];
} else {
  echo "no results :(";
}

$sqlPage = "select blog_id, blog_title, blog_content from blog_posts where blog_id = $blog_id";

$posts = $link->query($sqlPage);

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
    <link rel="stylesheet" href="css/highlight.default.min.css">
  </head>
  <body>

    <div class="container">

      <?php require_once("master/header.php"); ?>

      <?php
      if ($posts->num_rows > 0) {
         if ($row = $posts->fetch_assoc()) {
            $blogContent = $row["blog_content"];
        }
      } else {
         echo "No Result:(";
      }
      ?>
      <textarea id="hide_blog_content" style="display: none;"><?php echo $blogContent ?></textarea>

      <div class="row">
            <div class="col-sm-8" id="blog_content"></div>
      </div>

      <?php require_once("master/footer.php"); ?>

    </div>

    <?php require_once("master/go-top.php"); ?>

    <script src="js/jquery.1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/highlight.min.js"></script>
    <script src="js/marked.min.js"></script>
    <script type="text/javascript">
      var blogContent = document.querySelector('#blog_content');
      var hideBlogContent = document.querySelector('#hide_blog_content');
      marked.setOptions({
        highlight: function (code) {
           return hljs.highlightAuto(code).value;
        }
      });
      blogContent.innerHTML = marked(hideBlogContent.value);
    </script>
  </body>
</html>