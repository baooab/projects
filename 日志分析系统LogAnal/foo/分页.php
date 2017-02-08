<?php  ?>
<table width="95%" border="1" cellspacing="0" cellpadding="0" align="center">
      <tr align="center" height="30px">
        <td>文章标题</td>
        <td>文章内容</td>
        <td>编辑</td>        
      </tr>    
 <?php
    
        try{
        header("content:text/html; charset:utf-8");
        // include "conn/conn.php";

$pdo = new PDO('mysql:host=192.168.70.16;dbname=Syslog;charset=utf8mb4', 'root', 'Abcdef1234');

        if(@$_GET['page']!=""){
            $page=$_GET['page'];    
        }else{
            $page=1;    
        }
        if($page){
            $page_size=25;
            $query="select count(*) as total from SystemEvents";
            
            $result_acticle=$pdo->prepare($query);
            $result_acticle->execute();
            $msg_count =$result_acticle->rowCount($result_acticle,0,"total");
            $page_count=ceil($msg_count/$page_size);
            $offset=($page-1)*$page_size;
            
            $sql="SELECT * FROM SystemEvents order by now desc limit $offset,$page_size ";
            if(@$_POST['btnSea']=="查询"){
                $txtb= $_POST['txtbook'];
                $sql = "SELECT * FROM SystemEvents limit 25";
                
            }
            $result_acticle=$pdo->prepare($sql);
            $result_acticle->execute();
        
            while($res_article=$result_acticle->fetch(PDO::FETCH_ASSOC)){
                ?>
          <tr height="30px">
            <td align="center"><?php echo $res_article[0]; ?></td>
            <td>&nbsp;<?php echo $res_article[1]; ?></td>
            <td width="50px" align="center"><a href="modify.php?id='<?php echo $res_article[0]; ?>'">编辑</a></td>
            <td width="50px" align="center"><a href="delete.php?id='<?php echo $res_article[0]; ?>'">删除</a></td>
          </tr>  
                
            <?php
            }
        }
        
        }catch(Exception $ex){
            echo $ex->getMessage();    
        }
?>
</table>

<table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>页次:<?php echo $page?>/<?php echo $page_count?>页&nbsp;记录:<?php echo $msg_count?>条</td>
        <td>&nbsp;</td>
       
        <td width="40px"><a href="edit.php?page=1">首页</a></td>        
        <td width="45px"><a href="edit.php?page=<?php
        if($page==1){
            echo "1";
        }else{
             echo $page-1;
        }         
         ?>">上一页</a></td>
        
        <td width="45px"><a href="edit.php?page=<?php 
        if($page==$page_count){
            echo $page_count;
        }else{
            echo $page+1;
        }
        ?>">下一页</a></td>
        <td width="40px"><a href="edit.php?page=<?php echo $page_count?>">尾页</a></td>
      </tr>
</table>