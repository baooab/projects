<?php

include "master/conn.php";

$g_query_string = $_SERVER["QUERY_STRING"];
$g_dealed_query_string = substr($g_query_string, strpos($g_query_string,"&"));

$g_page       = @$_GET["page"];
$g_startTime  = @$_GET["startTime"];
$g_endTime    = @$_GET["endTime"];
$g_servers    = @$_GET["servers"];
$g_priorities = @$_GET["priorities"];
$g_eventID    = @$_GET["eventID"];

$page = 1;
if($g_page != "") {
    $page = $g_page;
}
$page_size = 25;
$offset = ($page - 1) * $page_size;

$timeQuerySQL = "";
$serversQuerySQL = "";
$prioritiesQuerySQL = "";
$eventIDQuerySQL = "";
$querySQLCondition = "";

if ($g_startTime!="" && $g_endTime != "") {
	$timeQuerySQL = " DeviceReportedTime between '" . $g_startTime . "' and '" . $g_endTime . "' ";
} else if ($g_startTime != "") {
	$timeQuerySQL  = " DeviceReportedTime >= '" . $g_startTime . "' ";
} else if ($g_endTime != ""){
	$timeQuerySQL = " DeviceReportedTime <= '" . $g_endTime . "' ";
}

if (!empty($g_servers)) {
	foreach ($g_servers as $key => $server) {
		$g_servers[$key] = "'" . $server . "'";
	}
	$serversQuerySQL =  " FromHost in(" . implode(',', $g_servers) . ") ";
}
if (!empty($g_priorities)) {
	$prioritiesQuerySQL =  " Priority in(" . implode(',', $g_priorities) . ") ";
}

if (!empty($g_eventID)) {
	$eventIDQuerySQL = " Message LIKE '%" . $g_eventID . ": %'";
}

// 拼接查询语句的条件部分
if ($timeQuerySQL != "") {
	$querySQLCondition =  $querySQLCondition . "AND" . $timeQuerySQL;
}
if ($serversQuerySQL != "") {
	$querySQLCondition =  $querySQLCondition . "AND" . $serversQuerySQL;
}
if ($prioritiesQuerySQL != "") {
	$querySQLCondition =  $querySQLCondition . "AND" . $prioritiesQuerySQL;
}
if ($eventIDQuerySQL != "") {
	$querySQLCondition =  $querySQLCondition . "AND" . $eventIDQuerySQL;
}
if ($querySQLCondition != "") {
	// 将字符串中第一个出现的“AND”替代为“WHERE”，详见http://newsourcemedia.com/blog/php-replace-only-first-occurrence-of-a-string-match/
	$querySQLCondition = preg_replace('/AND/', 'WHERE', $querySQLCondition, 1);
}
//echo $querySQLCondition ; return;

$queryCountSQL = "SELECT COUNT(*) AS total FROM SystemEvents " . $querySQLCondition;
$resultCount = $dbh->query($queryCountSQL);
$msg_count = $resultCount->fetchColumn();
$page_count = ceil($msg_count/$page_size);

// 数据库数据
$querySQL = "SELECT * FROM SystemEvents " . $querySQLCondition . " ORDER BY ID desc LIMIT $offset,$page_size";
//echo $querySQL; return;

$result = $dbh->query($querySQL);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">
		<title>结果 - 服务器日志查阅系统</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
	</head>
	<body>
	<body>
		<div id="header">
			<div class="col w5 bottomlast">
				<!-- <h2>SystemEvents表格数据查看</h2> -->
			</div>
			<div class="col w5 last right bottomlast">
				<!-- <p class="last">Logged in as <span class="strong">Admin,</span> <a href="">Logout</a></p> -->
			</div>
			<div class="clear"></div>
		</div>
		<div id="wrapper">
			<div id="minwidth">
				<div id="holder">

					<div id="submenu">
						<div class="modules_left">
							<script type="text/javascript">
								function _zb_backIndexPage() {
									location.href = "index.php";
								}
							</script>
							<div class="module buttons">
								<a href="javascript:void(0);" class="dropdown_button" onclick="_zb_backIndexPage();"><span>首页</span></a>
							</div>
						</div>
						<div class="title">
							<img src="images/logo/logo.png" class="logo">日志分析系统 - 结果
						</div>
						<div class="modules_right">
						</div>
					</div>
					<div id="desc">
						<div class="body">

							<div class="clear"></div>

							<ul>
								<?php
									if (!empty($g_servers)) {
								?>
								<li><span class="strong">服&nbsp;&nbsp;务&nbsp;&nbsp;器:</span>
									<?php echo implode(',', $g_servers); ?>
								</li>
								<?php
									}
								?>

								<?php
									if (!empty($g_priorities)) {
								?>
								<li><span class="strong">事件优先级:</span>
									<?php
										foreach ($g_priorities as $key => $g_priority) {
											switch ($g_priority) {
												case "0":
													echo "EMERG ";
													break;
												case "1":
													echo "ALERT ";
													break;
												case "2":
													echo "CRIT ";
													break;
												case "3":
													echo "ERR ";
													break;
												case "4":
													echo "WARNING ";
													break;
												case "5":
													echo "NOTICE ";
													break;
												case "6":
													echo "INFO ";
													break;
												case "7":
													echo "DEBUG ";
													break;
												default:
													echo "Unknown:( ";
													break;
											}
										}
									?>
								</li>
								<?php
									}
								?>

								<?php
									if (!empty($g_startTime) && !empty($g_endTime)) {
								?>
								<li><span class="strong">时间区间:</span>
									<?php echo $g_startTime ?> 至 <?php echo $g_endTime ?>
								</li>
								<?php
									}
								?>

								<?php
									if (!empty($g_eventID)) {
								?>
								<li><span class="strong">事件ID:</span>
									<?php echo $g_eventID ?>
								</li>
								<?php
									}
								?>

							</ul>

							<div id="buttons2">
							<div class="col w10">
								<div class="content">
									<p class="buttons_demo">
										<a href="javascript:void(0);" class="button"><span>页次:<?php echo $page?>/<?php echo $page_count?>页&nbsp;记录:<?php echo $msg_count?>条</span></a>

										<a class="button yellow" href="results.php?page=1<?php echo $g_dealed_query_string;?>"><span>首页</span></a>
								        <a class="button yellow" href="results.php?page=<?php
								        if($page==1){
								            echo "1" . $g_dealed_query_string;;
								        }else{
								             echo ($page-1) . $g_dealed_query_string;
								        }
								         ?>"><span>上一页</span></a>

								        <a class="button yellow" href="results.php?page=<?php
								        if($page==$page_count){
								            echo $page_count . $g_dealed_query_string;
								        }else{
								            echo ($page+1) . $g_dealed_query_string;
								        }
								        ?>"><span>下一页</span></a>
								        <a class="button yellow" href="results.php?page=<?php echo $page_count . $g_dealed_query_string?>"><span>尾页</span></a>
									</p>
								</div>
							</div>
							<div class="clear"></div>
							</div><!-- End  div#buttons-->

							<div id="table">
							<div class="col w10 last">
								<div class="content">
									<table>
										<tbody>
										<tr>
		<!-- 字段序列 ["ID", "CustomerID", "ReceivedAt", "DeviceReportedTime", "Facility", "Priority", "FromHost", "Message", "NTSeverity", "Importance", "EventSource", "EventUser", "EventCategory", "EventID", "EventBinaryData", "MaxAvailable", "CurrUsage", "MinUsage", "MaxUsage", "InfoUnitID", "SysLogTag", "EventLogType", "GenericFileName", "SystemID", "processid"]
		-->
											<!-- <th class="checkbox"><input name="checkbox" type="checkbox"></th> -->
											<th>事件ID</th>
											<th>ReceivedAt</th>
											<th>DeviceReportedTime</th>
											<th>Priority</th>
											<th>FromHost</th>
											<th>Message</th>
										</tr>
<?php foreach($result as $row) { ?>
										<tr>
											<!-- <td class="checkbox"><input name="checkbox" type="checkbox"></td>  -->
											<td>
											<?php
												$Message = $row["Message"];
												$index = strpos($Message, ": ");

												if ($index) {
													echo substr($Message, 0, $index);
												} else {
													echo "X";
												}
											?>
											</td>
										    <td><?php echo ($row["ReceivedAt"]) ?> </td>
										    <td><?php echo ($row["DeviceReportedTime"]) ?> </td>

											<?php
											$Priority = $row["Priority"];
											if ($Priority == "7") {
											?>
											<td><a class="button green Priority7" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>DEBUG</span></a></td>
											<?php
											} else if ($Priority == "6"){
											?>
											<td><a class="button green Priority6" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>INFO</span></a></td>
											<?php
											} else if ($Priority == "5"){
											?>
											<td><a class="button green Priority5" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>NOTICE</span></a></td>
											<?php
											} else if ($Priority == "4"){
											?>
											<td><a class="button yellow Priority4" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>WARNING</span></a></td>
											<?php
											} else if ($Priority == "3"){
											?>
											<td><a class="button red Priority3" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>ERR</span></a></td>
											<?php
											} else if ($Priority == "2"){
											?>
											<td><a class="button red Priority2" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>CRIT</span></a></td>
											<?php
											} else if ($Priority == "1"){
											?>
											<td><a class="button red Priority1" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>ALERT</span></a></td>
											<?php
											} else if ($Priority == "0"){
											?>
											<td><a class="button green Priority0" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span>EMERG</span></a></td>
										    <?php
											} else {
											?>
											<td><a class="button PriorityDontKonw" href="details.php?ID=<?php echo ($row["ID"]) ?>"><span><?php echo $Priority ?></span></a></td>
											<?php
											}
											?>

										    <td><?php echo ($row["FromHost"]) ?> </td>
										    <td>
									    	<?php
										    	if ($index) {
													echo substr($Message, $index + 2);
												} else {
													echo $Message;
												}
									    	?>
										    </td>
										</tr>
<?php
} // End foreach
?>
									</tbody></table>
								</div>
							</div>
							<div class="clear"></div>
							</div><!-- End  div#table-->

							<div id="buttons" class="help">
							<div class="col w10">
								<div class="content">
									<p class="buttons_demo">
										<a href="javascript:void(0);" class="button"><span>页次:<?php echo $page?>/<?php echo $page_count?>页&nbsp;记录:<?php echo $msg_count?>条</span></a>

										<a class="button yellow" href="results.php?page=1<?php echo $g_dealed_query_string;?>"><span>首页</span></a>
								        <a class="button yellow" href="results.php?page=<?php
								        if($page==1){
								            echo "1" . $g_dealed_query_string;;
								        }else{
								             echo ($page-1) . $g_dealed_query_string;
								        }
								         ?>"><span>上一页</span></a>

								        <a class="button yellow" href="results.php?page=<?php
								        if($page==$page_count){
								            echo $page_count . $g_dealed_query_string;
								        }else{
								            echo ($page+1) . $g_dealed_query_string;
								        }
								        ?>"><span>下一页</span></a>
								        <a class="button yellow" href="results.php?page=<?php echo $page_count . $g_dealed_query_string?>"><span>尾页</span></a>
									</p>
								</div>
							</div>
							<div class="clear"></div>
							</div><!-- End  div#buttons-->

							<div class="clear"></div>
						</div>
						<div class="clear"></div>
						<div id="body_footer">
							<div id="bottom_left"><div id="bottom_right"></div></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		include "master/footer.php";
		?>

</body>
</html>