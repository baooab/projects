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
$querySQL = "SELECT ID, CustomerID, ReceivedAt, DeviceReportedTime, Priority, FromHost, Message from SystemEvents order by ID desc limit $offset, $page_size";
$result = $dbh->query($querySQL);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<title>Gray Admin Template</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/lanren.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/jquery/datetimepicker/jquery.datetimepicker.css"/>

		<style type="text/css">
			.content {
				overflow: auto;
			}
			#submenu .title {
				width: 222px;
			}
			
			fieldset {
				border: 1px solid #CCC;
				padding: .5em;
				border-radius: .2em;
			}

			form label {
				display: inline-block;
			}

			.button input[type="checkbox"]{
				float: left;
				margin-top: 8px;
			}
	

			._zb_icon {
			    background-image: url(images/icons_gray.png);
			    height: 18px;
				width: 18px;
				display: inline-block;
			}
			._zb_icon.plus {
   				 background-position: -61px -349px;

   			}
   			._zb_icon.minus {
   				 background-position: -13px -349px;
   			}
			
			legend {
				cursor: pointer;
			}
			
		</style>

		<script type="text/javascript">

		function fuc() {
				var _zb_checkboxs_searchYinsu1 = document.querySelectorAll('#searchYinsu1 input[type=checkbox]'),
					_zb_checkboxs_searchYinsu2 = document.querySelectorAll('#searchYinsu2 input[type=checkbox]'),
					_zb_date_timepicker_start_input  = document.querySelector('#date_timepicker_start'),
					_zb_date_timepicker_end_input    = document.querySelector('#date_timepicker_end'),
					_zb_query_URL = "results.php?page=1";

				for (var i = 0; i < _zb_checkboxs_searchYinsu1.length; i++) {
					if (_zb_checkboxs_searchYinsu1[i].checked) {
						_zb_query_URL = _zb_query_URL + "&servers[]=" + _zb_checkboxs_searchYinsu1[i].value;
					}
				}

				for (var j = 0; j < _zb_checkboxs_searchYinsu2.length; j++) {
					if (_zb_checkboxs_searchYinsu2[j].checked) {
						_zb_query_URL = _zb_query_URL + "&priorities[]=" + _zb_checkboxs_searchYinsu2[j].value;
					}
				}

				_zb_query_URL = _zb_query_URL + "&startTime=" + _zb_date_timepicker_start_input.value + "&endTime=" + _zb_date_timepicker_end_input.value;
				location.href = _zb_query_URL;	
		}
		</script>

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
								function _zb_refreshPage() {
									location.href = "./?timestamp=" + new Date().getTime();
								}
							</script>
							<div class="module buttons">
								<a href="javascript:void(0);" class="dropdown_button" onclick="_zb_refreshPage();"><span>刷新</span></a>
							</div>
						</div>
						<div class="title">
							SystemEvents表数据
						</div>
						<div class="modules_right">
						</div>
					</div>
					<div id="desc">
						<div class="body">

							<div class="clear"></div>

							<div id="searchYinsu1">
							<h2>服务器过滤：</h2>

							<div class="clear"></div>
							</div><!-- End  div#form-->

							
							<div id="searchYinsu2" class="help">
							<h2>时间及事件优先级过滤：</h2>
							<!-- 条件搜索：时间 -->
							<div class="col w5">
								<div class="content">
									
										<fieldset>
											<legend></legend>
											<table id="">
												<tbody>
												<tr>
						                            <td>开始时间</td>
						                            <td>
						                                <input id="date_timepicker_start"  name="startTime" type="text">
						                            </td>
						                            <td>结束时间</td>
						                            <td>
						                                <input id="date_timepicker_end" name="endTime"  type="text">
						                            </td>
						                        </tr>  
						                        <tr>
						                            <td colspan="4">
						                               <!--  <input value="全选" onclick="checkAll()"  type="button">
						                                <input value="清除" onclick="deleteAll()"  type="button">
						                                <input value="反选" onclick="ReverseAll()"  type="button"> 
						                                <input value="查询" onclick="return checkrbl();" class="CRSButton60" id="" name="" type="submit">-->
						                                <a href="javascript:void(0)" onclick="fuc()" type="button" class="button"><span>查询</span></a>
						                            </td>
						                        </tr>
											</tbody></table>
										</fieldset>
									
								</div>
							</div>

							<!-- 条件搜索：事件优先级 -->
							<div class="col w5 last" style="padding-top: 0.9em;">
								<div class="content">
									<p class="buttons_demo">
								    	<a id="Priority-7-Container"class="button green" href="javascript:void(0);"><input id="Priority-7" name="priority" value="7" type="checkbox" checked="checked"><span>DEBUG</span></a>
										<a id="Priority-6-Container" class="button green" href="javascript:void(0);" ><input id="Priority-6" name="priority" value="6" type="checkbox" checked="checked"><span>INFO</span></a>
										<a id="Priority-5-Container" class="button green" href="javascript:void(0);"><input id="Priority-5" name="priority" value="5" type="checkbox" checked="checked"><span>NOTICE</span></a>
										<a id="Priority-4-Container" class="button yellow" href="javascript:void(0);"><input id="Priority-4" name="priority" value="4" type="checkbox" checked="checked"><span>WARNING</span></a>
										<a id="Priority-3-Container" class="button red" href="javascript:void(0);"><input id="Priority-3" name="priority" value="3" type="checkbox" checked="checked"><span>ERR</span></a>
										<a id="Priority-2-Container" class="button red" href="javascript:void(0);"><input id="Priority-2" name="priority" value="2" type="checkbox" checked="checked"><span>CRIT</span></a>
										<a id="Priority-1-Container" class="button red" href="javascript:void(0);"><input id="Priority-1" name="priority" value="1" type="checkbox" checked="checked"><span>ALERT</span></a>
										<a id="Priority-0-Container" class="button red" href="javascript:void(0);"><input id="Priority-0" name="priority" value="0" type="checkbox" checked="checked"><span>EMERG</span></a>
									</p>
								</div>
							</div>

							<div class="clear"></div>
							</div><!-- End  div#searchYinsu-->

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
											<!-- <th>CustomerID</th> -->
											<th>ReceivedAt</th>
											<th>DeviceReportedTime</th>
											<!-- <th>Facility</th> -->
											<th>Priority</th>
											<th>FromHost</th>
											<th>Message</th>
<!-- 										<th>NTSeverity</th>
											<th>Importance</th>
											<th>EventSource</th>
											<th>EventUser</th>
											<th>EventCategory</th>
											<th>EventID</th>
											<th>EventBinaryData</th>
											<th>MaxAvailable</th>
											<th>CurrUsage</th>
											<th>MinUsage</th>
											<th>MaxUsage</th>
											<th>InfoUnitID</th>
											<th>SysLogTag</th>
											<th>EventLogType</th>
											<th>GenericFileName</th>
											<th>SystemID</th>
											<th>processid</th>  -->
										</tr>
<?php foreach($result as $row) { ?>
										<tr>
											<!-- <td class="checkbox"><input name="checkbox" type="checkbox"></td>  -->
											<td><?php echo ($row["ID"]) ?> </td>
										   <!--  <td><?php echo ($row["CustomerID"]) ?> </td> -->
										    <td><?php echo ($row["ReceivedAt"]) ?> </td>
										    <td><?php echo ($row["DeviceReportedTime"]) ?> </td>
										   <!--  <td><?php echo ($row["Facility"]) ?> </td> -->
											
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
										    <td><?php echo ($row["Message"]) ?> </td>
										  <!--   <td><?php echo ($row["NTSeverity"]) ?> </td>
										    <td><?php echo ($row["Importance"]) ?> </td>
										    <td><?php echo ($row["EventSource"]) ?> </td>
										    <td><?php echo ($row["EventUser"]) ?> </td>
										    <td><?php echo ($row["EventCategory"]) ?> </td>
										    <td><?php echo ($row["EventID"]) ?> </td>
										    <td><?php echo ($row["EventBinaryData"]) ?> </td>
										    <td><?php echo ($row["MaxAvailable"]) ?> </td>
										    <td><?php echo ($row["CurrUsage"]) ?> </td>
										    <td><?php echo ($row["MinUsage"]) ?> </td>
										    <td><?php echo ($row["MaxUsage"]) ?> </td> 
										    <td><?php echo ($row["InfoUnitID"]) ?> </td>
										    <td><?php echo ($row["SysLogTag"]) ?> </td>
										    <td><?php echo ($row["EventLogType"]) ?> </td>
										    <td><?php echo ($row["GenericFileName"]) ?> </td>
										    <td><?php echo ($row["SystemID"]) ?> </td>
										    <td><?php echo ($row["processid"]) ?> </td> -->
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

	<script src="js/jquery/1.10.2/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery/datetimepicker/2.5.4/jquery.datetimepicker.full.js" type="text/javascript" charset="utf-8"></script>
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
				_zb_lastChildofSearchYinsu1 = searchYinsu1.lastElementChild,
				_zb_searchYinsu1Html = "",
				_zb_tempHtml = "",
				_zb_tempCheckboxHtml = "",
				_zb_tempServerArea = {},
				_zb_tempIPs = [],
				_zb_tempIP = {},
				_zb_searchYinsu1TempHtmlContainer = [],
			    _zb_i = 0,
			    _zb_j = 0,
				_zb_length = _zb_SERVERSINFO.length;
			for (_zb_i = 0; _zb_i < _zb_length; _zb_i++) {
				_zb_tempServerArea = _zb_SERVERSINFO[_zb_i];
				_zb_tempIPs = _zb_tempServerArea['IPs'];

				_zb_tempHtml = "";
				_zb_tempIPs
				_zb_tempHtml += '<div class="col w3">';
					_zb_tempHtml += '<div class="content">';
						_zb_tempHtml += '<fieldset>';
							_zb_tempHtml += '<legend><span>' + _zb_tempServerArea['serverArea'] + '</span><small class="_zb_icon plus"></small></legend>';				
							_zb_tempHtml += '<table>';
							_zb_tempHtml += '<tbody>';
							for (_zb_j = 0; _zb_j < _zb_tempIPs.length; _zb_j++) {
								_zb_tempHtml += '<tr>';
								_zb_tempIP = _zb_tempIPs[_zb_j];
								if (_zb_tempIP.cssStyle === "") {
								_zb_tempHtml += '<td><input id="Server_IP_'+_zb_tempIP.value+'" name="servers" value="'+_zb_tempIP.value+'" type="checkbox"><label for="">'+_zb_tempIP.value+' '+_zb_tempIP.extraInfo+'</label></td>';
								} else {
								_zb_tempHtml += '<td style="background-color:'+_zb_tempIP.cssStyle+'"><input id="Server_IP_'+_zb_tempIP.value+'" name="servers" value="'+_zb_tempIP.value+'" type="checkbox"><label for="">'+_zb_tempIP.value+' '+_zb_tempIP.extraInfo+'</label></td>';
								}
								_zb_tempHtml += '</tr>';
							}	
							_zb_tempHtml += '</tbody></table>';
						_zb_tempHtml += '</fieldset>';
					_zb_tempHtml += '</div>';
				_zb_tempHtml += '</div><!-- End div.[class="col w3"] -->';
				$(_zb_tempHtml).insertBefore($(_zb_lastChildofSearchYinsu1));
			}


			// 扩大事件优先级的选择范围
			$(_zb_searchYinsu2).on('click', 'a[id^=Priority-]', function(e) {
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