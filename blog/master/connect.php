<?php

	require_once("config.php");
	/**
	 * 数据库连接
	 */
	// connect with MySQL
	$link = mysqli_connect(HOST, USER, PASS);
	if (!$link) {
		echo mysql_error($link);
	}
	// select a database
	if (!mysqli_select_db($link, DB_NAME)) {
		echo mysql_error($link);
	}
	// set charset utf8
	if (!mysqli_query($link, "set names utf8")) {
		echo mysql_error($link);
	}
?>