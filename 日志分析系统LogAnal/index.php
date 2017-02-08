<?php

include "master/conn.php";

$page = 1;
if(@$_GET["page"] != "") {
    $page = $_GET["page"];
}
$page_size = 25;
$queryCountSQL = "SELECT COUNT(*) as total from SystemEvents";
$resultCount = $dbh->query($queryCountSQL);
$offset = ($page - 1) * $page_size;
$msg_count = $resultCount->fetchColumn();
$page_count = ceil($msg_count/$page_size);

// 数据库数据
$querySQL = "SELECT ID, ReceivedAt, DeviceReportedTime, Priority, FromHost, Message from SystemEvents order by ID desc limit $offset, $page_size";
$result = $dbh->query($querySQL);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<title>首页 - 服务器日志查阅系统</title>
		<link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/jquery/datetimepicker/jquery.datetimepicker.css"/>
		<link rel="stylesheet" href="css/lanren.css" type="text/css" media="screen" charset="utf-8" />
		<script src="js/jquery/1.10.2/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery/datetimepicker/2.5.4/jquery.datetimepicker.full.js" type="text/javascript" charset="utf-8"></script>

		<style type="text/css">
			#searchYinsu2 .buttons_demo .button input[type="checkbox"]{
				float: left;
				margin-top: 8px;
			}

			#category-2016 table tr {
				display: inline-block;
				margin-right: 2px;
				cursor: pointer;
			}

			#category-2016 table tr>td{
				width:208px;
				height: 75px;
				word-break: break-all;
			}

			#searchYinsu1 .buttons_demo .button input[type="checkbox"]{
				float: left;
				margin-top: 8px;
			}
		</style>

		<script type="text/javascript">

		var _zb_tempParentParentNode,
			_zb_tempParentParentsCheckboxes,
			_zb_tempParentParentsCheckbox,
			_zb_tempParentParentsCheckboxesLength,
			_zb_index;
		function checkAll(i) {
			_zb_tempParentParentNode = i.parentNode.parentNode.parentNode;
			_zb_tempParentParentsCheckboxes = _zb_tempParentParentNode.querySelectorAll('input[type=checkbox]');
			_zb_tempParentParentsCheckboxesLength = _zb_tempParentParentsCheckboxes.length;
			for (_zb_index = 0; _zb_index < _zb_tempParentParentsCheckboxesLength; _zb_index++) {
				_zb_tempParentParentsCheckboxes[_zb_index].checked = true;
			}
		}

		function deleteAll(i) {
			_zb_tempParentParentNode = i.parentNode.parentNode.parentNode;
			_zb_tempParentParentsCheckboxes = _zb_tempParentParentNode.querySelectorAll('input[type=checkbox]');
			_zb_tempParentParentsCheckboxesLength = _zb_tempParentParentsCheckboxes.length;
			for (_zb_index = 0; _zb_index < _zb_tempParentParentsCheckboxesLength; _zb_index++) {
				_zb_tempParentParentsCheckboxes[_zb_index].checked = false;
			}
		}

		function reverseAll(i) {
			_zb_tempParentParentNode = i.parentNode.parentNode.parentNode;
			_zb_tempParentParentsCheckboxes = _zb_tempParentParentNode.querySelectorAll('input[type=checkbox]');
			_zb_tempParentParentsCheckboxesLength = _zb_tempParentParentsCheckboxes.length;
			for (_zb_index = 0; _zb_index < _zb_tempParentParentsCheckboxesLength; _zb_index++) {
				if (_zb_tempParentParentsCheckboxes[_zb_index].checked) {
					_zb_tempParentParentsCheckboxes[_zb_index].checked = false;
				} else {
					_zb_tempParentParentsCheckboxes[_zb_index].checked = true;
				}
			}
		}

		// 日期加一天工具函数  使用：addDate('2016-10-31', 1); 得到 2016-11-01
        function addDate(date, days) {
        	if (!date) {
        		return "";
        	}
            if (days == undefined || days == '') {
                days = 1;
            }
            var date = new Date(date);
            date.setDate(date.getDate() + days);
            var month = date.getMonth() + 1;
            var day = date.getDate();
            return date.getFullYear() + '-' + getFormatDate(month) + '-' + getFormatDate(day);
        }
        // 日期月份/天的显示，如果是1位数，则在前面加上'0'
        function getFormatDate(arg) {
            if (arg == undefined || arg == '') {
                return '';
            }

            var re = arg + '';
            if (re.length < 2) {
                re = '0' + re;
            }

            return re;
        }

	    // console.log();

			function _zb_requestUrl() {
				var _zb_servers_checkboxs_searchYinsu1 = document.querySelectorAll('#allsort input[type=checkbox]'),
					_zb_priorities_checkboxs_searchYinsu1 = document.querySelectorAll('#searchYinsu1 .buttons_demo input[type=checkbox]'),
					_zb_date_timepicker_start_input  = document.querySelector('#date_timepicker_start'),
					_zb_date_timepicker_end_input    = document.querySelector('#date_timepicker_end'),
					_zb_event_ID                     = document.querySelector('#event_ID'),
					_zb_query_URL = "results.php?page=1";

				//console.log('// 服务器↓');
				for (var i = 0; i < _zb_servers_checkboxs_searchYinsu1.length; i++) {
					if (_zb_servers_checkboxs_searchYinsu1[i].checked) {
						//console.log(_zb_servers_checkboxs_searchYinsu1[i].value);
						_zb_query_URL = _zb_query_URL + "&servers[]=" + _zb_servers_checkboxs_searchYinsu1[i].value;
					}
				}

				//console.log('// 安全级别↓');

				for (var j = 0; j < _zb_priorities_checkboxs_searchYinsu1.length; j++) {
					if (_zb_priorities_checkboxs_searchYinsu1[j].checked) {
						//console.log(_zb_priorities_checkboxs_searchYinsu1[j].value);
						_zb_query_URL = _zb_query_URL + "&priorities[]=" + _zb_priorities_checkboxs_searchYinsu1[j].value;
					}
				}

				//console.log('// 时间范围↓');

				//console.log(_zb_date_timepicker_start_input.value + ', ' + _zb_date_timepicker_end_input.value);
				//console.log('处理后的结束时间：' + addDate(_zb_date_timepicker_end_input.value, 1));
				_zb_query_URL = _zb_query_URL + "&startTime=" + _zb_date_timepicker_start_input.value + "&endTime=" + addDate(_zb_date_timepicker_end_input.value, 1);

				_zb_query_URL = _zb_query_URL + "&eventID=" + _zb_event_ID.value;

				//console.log("请求URL：" + _zb_query_URL);
				location.href = _zb_query_URL;

			}
		</script>

	</head>
	<body>
	<body>
		<div id="header">
			<div class="col w5 bottomlast">
				<!-- <h2><img src="images/logo/logo.png" class="logo">日志分析系统</h2> -->
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
								function _zb_feedbackPage() {
									location.href = "feedback.html";
								}
							</script>
							<div class="module buttons">
								<a href="javascript:void(0);" class="dropdown_button" onclick="_zb_feedbackPage();"><span>我要反馈</span></a>
							</div>
						</div>
						<div class="title">
							<img src="images/logo/logo.png" class="logo">日志分析系统 - 首页
						</div>
						<div class="modules_right">
						</div>
					</div>
					<div id="desc">
						<div class="body">

							<div class="clear"></div>

<div id="searchYinsu1">
							<div class="col w4">
								<h2>服务器：</h2>
								<div class="content">
									<div id="nav-2016">
										<div id="category-2016" onmouseover="this.className='on'" onmouseleave="this.className=''" class="">
											<div class="ld">
												<h2>服务器筛选<b></b></h2>
											</div>
											<div id="allsort">

											</div> <!-- End div# allsort-->
										</div>
									</div> <!-- End div#nav-2016 -->
								</div>
							</div>
							<!-- 事件优先级选择 -->
							<div class="col w6 last">
								<h2>事件优先级：</h2>
								<div class="content">
									<p class="buttons_demo">
								    	<a id="Priority-7-Container" class="button green" href="javascript:void(0);"><input id="Priority-7" name="priority" value="7" type="checkbox"><span>DEBUG</span></a>
										<a id="Priority-6-Container" class="button green" href="javascript:void(0);"><input id="Priority-6" name="priority" value="6" type="checkbox"><span>INFO</span></a>
										<a id="Priority-5-Container" class="button green" href="javascript:void(0);"><input id="Priority-5" name="priority" value="5" checked="checked" type="checkbox"><span>NOTICE</span></a>
										<a id="Priority-4-Container" class="button yellow" href="javascript:void(0);"><input id="Priority-4" name="priority" value="4" checked="checked" type="checkbox"><span>WARNING</span></a>
										<a id="Priority-3-Container" class="button red" href="javascript:void(0);"><input id="Priority-3" name="priority" value="3" checked="checked" type="checkbox"><span>ERR</span></a>
										<a id="Priority-2-Container" class="button red" href="javascript:void(0);"><input id="Priority-2" name="priority" value="2"  type="checkbox"><span>CRIT</span></a>
										<a id="Priority-1-Container" class="button red" href="javascript:void(0);"><input id="Priority-1" name="priority" value="1"  type="checkbox"><span>ALERT</span></a>
										<a id="Priority-0-Container" class="button red" href="javascript:void(0);"><input id="Priority-0" name="priority" value="0" type="checkbox"><span>EMERG</span></a>
									</p>
								</div>
							</div>

							<div class="clear"></div>
							</div><!-- End div#searchYinsu1 -->


							<div id="searchYinsu2" class="help">

							<h2>时间和事件ID：</h2>
							<!-- 条件搜索：时间 -->
							<div class="col w4">
								<div class="content">

										<fieldset>
											<legend></legend>
											<table id="">
												<tbody>
												<tr>
						                            <td>开始时间</td>
						                            <td>
						                                <input id="date_timepicker_start" name="startTime" type="text">
						                            </td>
						                            <td>结束时间</td>
						                            <td>
						                                <input id="date_timepicker_end" name="endTime" type="text">
						                            </td>
						                        </tr>
						                        <tr>
						                            <td>事件ID</td>
						                            <td>
						                                <input id="event_ID" name="event_ID" type="text">
						                            </td><td></td><td></td>
						                        </tr>
						                        <tr>
						                            <td colspan="4">
						                               <!--  <input value="全选" onclick="checkAll()"  type="button">
						                                <input value="清除" onclick="deleteAll()"  type="button">
						                                <input value="反选" onclick="ReverseAll()"  type="button">
						                                <input value="查询" onclick="return checkrbl();" class="CRSButton60" id="" name="" type="submit">-->
						                                <a href="javascript:void(0)" onclick="_zb_requestUrl()" type="button" class="button"><span>查询</span></a>
						                            </td>
						                        </tr>
											</tbody></table>
										</fieldset>

								</div>
							</div>

							<div class="clear"></div>
							</div><!-- End div#searchYinsu2 -->

							<div id="buttons2">
								<div class="col w5">
									<div class="content">
										<p class="buttons_demo">
											<a href="javascript:void(0);" class="button"><span>页次:<?php echo $page?>/<?php echo $page_count?>页&nbsp;记录:<?php echo $msg_count?>条</span></a>

											<a class="button yellow" href="index.php?page=1"><span>首页</span></a>
									        <a class="button yellow" href="index.php?page=<?php
									        if($page==1){
									            echo "1";
									        }else{
									             echo $page-1;
									        }
									         ?>"><span>上一页</span></a>

									        <a class="button yellow" href="index.php?page=<?php
									        if($page==$page_count){
									            echo $page_count;
									        }else{
									            echo $page+1;
									        }
									        ?>"><span>下一页</span></a>
									        <a class="button yellow" href="index.php?page=<?php echo $page_count?>"><span>尾页</span></a>
										</p>
									</div>
								</div>

								<div class="clear"></div>
							</div><!-- End  div#buttons2-->

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

										<a class="button yellow" href="index.php?page=1"><span>首页</span></a>
								        <a class="button yellow" href="index.php?page=<?php
								        if($page==1){
								            echo "1";
								        }else{
								             echo $page-1;
								        }
								         ?>"><span>上一页</span></a>

								        <a class="button yellow" href="index.php?page=<?php
								        if($page==$page_count){
								            echo $page_count;
								        }else{
								            echo $page+1;
								        }
								        ?>"><span>下一页</span></a>
								        <a class="button yellow" href="index.php?page=<?php echo $page_count?>"><span>尾页</span></a>
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

	<script src="data/serverInfo.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">

		jQuery(function(){
			// 事件插件初始化
			$.datetimepicker.setLocale("ch");
			jQuery("#date_timepicker_start").datetimepicker({
				format:"Y-m-d",
				onShow:function( ct ){
					this.setOptions({
						startDate:new Date(),
						maxDate:jQuery("#date_timepicker_end").val()?jQuery("#date_timepicker_end").val():0
					})
				},
				timepicker:false
			});
			jQuery("#date_timepicker_end").datetimepicker({
				format:"Y-m-d",
				onShow:function( ct ){
					this.setOptions({
						startDate:new Date(),
						minDate:jQuery("#date_timepicker_start").val()?jQuery("#date_timepicker_start").val():false,
						maxDate:0
					})
				},
				timepicker:false
			});

			// 服务器数据（data/serverInfo.js _zb_SERVERSINFO）读取与展示
			var _zb_searchYinsu1 = document.querySelector("#searchYinsu1"),
				_zb_searchYinsu2 = document.querySelector("#searchYinsu2"),
				_zb_allsort = document.querySelector("#allsort"),
				_zb_lastChildofSearchYinsu1 = searchYinsu1.lastElementChild,
				_zb_searchYinsu1Html = "",
				_zb_tempHtml = "",
				_zb_tempCheckboxHtml = "",
				_zb_tempServerArea = {},
				_zb_tempIP = {},
				_zb_searchYinsu1TempHtmlContainer = [],
			    _zb_i = 0,
			    _zb_j = 0,
				_zb_length = _zb_SERVERSINFO.length;

			for (_zb_i = 0; _zb_i < _zb_length; _zb_i++) {
				_zb_tempServerArea = _zb_SERVERSINFO[_zb_i];
				_zb_tempIPs = _zb_tempServerArea['IPs'];

				_zb_tempHtml = "";
				_zb_tempHtml += '<div class="item" onmouseover="this.className=\'item on\'" onmouseleave="this.className=\'item\'">';
					_zb_tempHtml += '<span><h3>' + _zb_tempServerArea['serverArea'] + '</h3></span>';
					_zb_tempHtml += '<div class="i-mc">';
						_zb_tempHtml += '<table><tbody>';
						for (_zb_j = 0; _zb_j < _zb_tempIPs.length; _zb_j++) {
							_zb_tempIP = _zb_tempIPs[_zb_j];
							_zb_tempHtml += '<tr>';
								_zb_tempHtml += '<td>';
									_zb_tempHtml += '<a class="ui-tdnk" href="javascript:void(0);" style="font-size: 14px;font-weight: bold;"><input id="Server_IP_'+_zb_tempIP.value+'" name="servers" value="'+_zb_tempIP.serverName+'" type="checkbox">'+_zb_tempIP.serverName+'</a>';
									_zb_tempHtml += '<br />';
									_zb_tempHtml += _zb_tempIP.value + '，' + _zb_tempIP.extraInfo;
								_zb_tempHtml += '</td>';
							_zb_tempHtml += '</tr>';
						}

							_zb_tempHtml += '<tr style="display: block;">';
								_zb_tempHtml += '<td style="height:40px;">';
									_zb_tempHtml += '<input value="全选" onclick="checkAll(this)"  type="button">';
									_zb_tempHtml += '<input value="清除" onclick="deleteAll(this)"  type="button">';
									_zb_tempHtml += '<input value="反选" onclick="reverseAll(this)"  type="button"> ';
								_zb_tempHtml += '</td>';
							_zb_tempHtml += '</tr>';
						_zb_tempHtml += '</tbody></table>';
					_zb_tempHtml += '</div>';
				_zb_tempHtml += '</div>';
				$(_zb_allsort).append(_zb_tempHtml);
			}

			// 扩大服务器复选框的选择范围
			var _zb_tempCheckbox;
			$(_zb_searchYinsu1).on('click', 'tr', function(e) {
				if ("checkbox" === e.target.type) {
					return ;
				}

				_zb_tempCheckbox = $(this).find('input[type=checkbox]')[0];
				if ("button" === e.target.type) {
					return ;
				}

				if (_zb_tempCheckbox.checked) {
					_zb_tempCheckbox.checked = false;
				} else {
					_zb_tempCheckbox.checked = true;
				}
			})

			// 扩大事件优先级的选择范围
			$(_zb_searchYinsu1).on('click', 'a[id^=Priority-]', function(e) {
				if ("checkbox" === e.target.type) {
					return ;
				}

				_zb_tempCheckbox = $(this).find('input[type=checkbox]')[0];
				if (_zb_tempCheckbox.checked) {
					_zb_tempCheckbox.checked = false;
				} else {
					_zb_tempCheckbox.checked = true;
				}
			})

		});

	</script>

</body>
</html>