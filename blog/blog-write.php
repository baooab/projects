<?php
require_once("master/connect.php");

$blog_id = null;
$get_blog_id = null;
$blog_content = null;
$blog_title = null;
$blog_category = null;

if (isset($_GET["blog_id"])) {
	$get_blog_id = $_GET["blog_id"];
} 
if (isset($_POST["blog_content"])) {
	$blog_content = $_POST["blog_content"];
	$blog_content = addslashes($blog_content);
} 
if (isset($_POST["blog_title"])) {
	$blog_title  = $_POST["blog_title"];
	$blog_title  = addslashes($blog_title);
} 
if (isset($_POST["blog_category"])) {
	$blog_category =  $_POST["blog_category"];
} 
if (isset($_POST["blog_id"])) {
	$blog_id = $_POST["blog_id"];
} 

$posts = null;
$updatedPost = null;
$selectPost  = null;

// 编辑文章
if (isset($get_blog_id) && !empty($get_blog_id)) {
    $sqlSelect = "select blog_id, blog_title, blog_content, blog_category from blog_posts where blog_id = $get_blog_id";
    $selectPost = $link->query($sqlSelect);
    if ($selectPost->num_rows > 0) {
        if ($row = $selectPost->fetch_assoc()) {
            $blogContent = $row["blog_content"];
            $blogId = $row["blog_id"];
            $blogTitle = $row["blog_title"];
            $blogCategory = $row["blog_category"];
        }
    }
} else {
    // 更新文章
    if (isset($blog_id) && !empty($blog_id)) {
        $sqlUpdate = "UPDATE `blog_posts` SET `blog_title` = '$blog_title', `blog_content` = '$blog_content', `blog_category` = '$blog_category',`blog_update` = now() WHERE `blog_posts`.`blog_id` = $blog_id";
        $updatedPost = $link->query($sqlUpdate);
        if ($updatedPost) {
          echo "Good Work!";
        } else {
             echo "error:" . $sql . "<br>" . $link->error;
        }
    // 新建文章
    } else {
        $sqlInsert = "INSERT INTO blog_posts (blog_title, blog_content, blog_create, blog_update, blog_category) VALUES ('$blog_title', '$blog_content', now(), now(), '$blog_category')";
        if (isset($blog_content) && !empty($blog_content)) {
          if ($link->query($sqlInsert) === TRUE) {
             echo "Good Work!";
          } else {
             echo "error:" . $sql . "<br>" . $link->error;
          }
        } else if (isset($_POST["blog_content"]) && empty($_POST["blog_content"])) {
          echo "No words :(";
        } else {

        }
    }
}

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
    <script src="js/highlight.min.js"></script>
    <script src="js/marked.min.js"></script>
    <style type="text/css">

    #showContainer {
      height: 560px;
    }

        #blog_content {
      height: 560px;
            width: 100%;
        }

        #markdownContainer, #showContainer, #blog_content {
            word-break: break-all;
            word-wrap: break-word;
      overflow: auto;
        }
    </style>
  </head>
  <body class="container">

    <?php require_once("master/header.php"); ?>

    <div class="row">
      <div id="markdownContainer" class="col-sm-6">
           <form name="post_form" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
               <h2><input id="blog_title" name="blog_title" type="text" value="<?php if(isset($blogTitle)) echo $blogTitle ?>" placeholder="文章标题"> </h2>
               <textarea id="blog_content" name="blog_content" cols="85" rows="22"><?php if(isset($blogContent)) echo $blogContent ?></textarea>
               <input type="text" value="<?php if(isset($blogCategory)) echo $blogCategory ?>" placeholder="标签" id="blog_category" name="blog_category">
               <input id="blog_id" name="blog_id" type="hidden" value="<?php if(isset($blogId)) echo $blogId ?>">
               <input type="submit" value="发表">
           </form>
       </div>
       <div class="col-sm-6">
            <h2 id="showTitle">&nbsp;</h2>
            <div id="showContainer" style="min-height: 375px;border: 1px solid #DBDFE6;border-radius: 3px;padding: .5em;"></div>
       </div>
    </div> <!-- End div.row -->

    <?php require_once("master/footer.php"); ?>

<script type="text/javascript">
    var showContainer = document.querySelector('#showContainer'),
        showTitle = document.querySelector('#showTitle'),
        blogContent = document.querySelector('#blog_content'),
        blogTitle = document.querySelector('#blog_title'),
        text      = blogContent.value,
        html      = marked(text);

    showContainer.innerHTML = html;
    showTitle.innerHTML = blogTitle.value;
    hljs.initHighlightingOnLoad();

    marked.setOptions({
      highlight: function (code) {
        return hljs.highlightAuto(code).value;
      }
    });

    blogContent.onkeyup = function () {
        text      = blogContent.value;
        html      = marked(text);
        showContainer.innerHTML = html;
    }

    blogTitle.onkeyup = function () {
        text      = blogTitle.value === "" ? " " : blogTitle.value;
        showTitle.innerHTML = text;
    }
</script>

      <script src="js/jquery.1.12.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
  </body>
</html>