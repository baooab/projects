<?php

// 数据库连接
$user = 'root';
$pass = 'Abcdef1234';
$dbh = new PDO('mysql:host=192.168.70.16;dbname=Syslog;charset=utf8mb4', 'root', 'Abcdef1234');

// 数据库数据条数
$page = 1;
if(@$_GET['page'] != "") {
    $page = $_GET['page'];    
} 
$page_size = 25;
$queryCountSQL = 'SELECT COUNT(*) as total from SystemEvents';
$resultCount = $dbh->query($queryCountSQL);
$offset = ($page - 1) * $page_size;
$msg_count = $resultCount->fetchColumn();
$page_count = ceil($msg_count/$page_size);

// 数据库数据
$querySQL = "SELECT * from SystemEvents order by ID desc limit $offset, $page_size";
$result = $dbh->query($querySQL);

foreach($result as $row) {
?>

    <?php echo ($row['ID']) ?>
    *<?php echo ($row['CustomerID']) ?>*
    <?php echo ($row['ReceivedAt']) ?>
    <?php echo ($row['DeviceReportedTime']) ?>
    <?php echo ($row['Facility']) ?>
    <?php echo ($row['Priority']) ?>
    <?php echo ($row['FromHost']) ?>
    <?php echo ($row['Message']) ?>
    <?php echo ($row['NTSeverity']) ?>
    <?php echo ($row['Importance']) ?>
    <?php echo ($row['EventSource']) ?>
    <?php echo ($row['EventUser']) ?>
    <?php echo ($row['EventCategory']) ?>
    <?php echo ($row['EventID']) ?>
    <?php echo ($row['EventBinaryData']) ?>
    <?php echo ($row['MaxAvailable']) ?>
    <?php echo ($row['CurrUsage']) ?>
    <?php echo ($row['MinUsage']) ?>
    <?php echo ($row['MaxUsage']) ?>
    <?php echo ($row['InfoUnitID']) ?>
    <?php echo ($row['SysLogTag']) ?>
    <?php echo ($row['EventLogType']) ?>
    <?php echo ($row['GenericFileName']) ?>
    <?php echo ($row['SystemID']) ?> 
    <?php echo ($row['processid']) ?> <br /><br />


<?php 
}
?>   

 <table border="1">
      <tr>
        <td>页次:<?php echo $page?>/<?php echo $page_count?>页&nbsp;记录:<?php echo $msg_count?>条</td>
       
        <td width="40px"><a href="mysqlConnTest.php?page=1">首页</a></td>        
        <td width="45px"><a href="mysqlConnTest.php?page=<?php
        if($page==1){
            echo "1";
        }else{
             echo $page-1;
        }         
         ?>">上一页</a></td>
        
        <td width="45px"><a href="mysqlConnTest.php?page=<?php 
        if($page==$page_count){
            echo $page_count;
        }else{
            echo $page+1;
        }
        ?>">下一页</a></td>
        <td width="40px"><a href="mysqlConnTest.php?page=<?php echo $page_count?>">尾页</a></td>
      </tr>
</table>




<?php 

$dbh = null;
 ?> 