<?php

// 数据库连接
$user = "root";
$pass = "Abcdef1234";
$dbh = null;
try {
	$dbh = new PDO("mysql:host=192.168.70.16;dbname=Syslog;charset=utf8mb4", "root", "Abcdef1234");
    //$dbh = new PDO("mysql:host=localhost;dbname=Syslog;charset=utf8mb4", "root", "Abcdef1234");
} catch(PDOException $e) {
	echo $e->getMessage();
}

 ?>