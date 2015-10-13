<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<body>
<div class="warrper">
	<div class="content">

	    <?php $this->load->view(''.$this->appfolder.'/path_view');?>

		<table style="width:60%; margin:5px 0px 0px 10px;" cellpadding="0" cellspacing="0" border="0">
			<tr align="left">
				<th colspan="4">系统信息</th>
			</tr>
			<tr>
				<td width="20%">服务器操作系统：</td>
				<td width="30%"><?php echo PHP_OS." ".$ip?></td>
				<td width="20%">Web 服务器：</td>
				<td width="30%"><?php echo $web_server?></td>
			</tr>
			<tr>
				<td>PHP 版本：</td>
				<td><?php echo $php_version?></td>
				<td>MySQL 版本：</td>
				<td><?php echo $mysql_version?></td>
			</tr>
			<tr>
				<td>时区设置：</td>
				<td><?php echo $timezone?></td>
				<td>GD 版本：</td>
				<td><?php echo $gd?></td>
			</tr>
			<tr>
				<td>文件上传的最大大小：</td>
				<td><?php echo $max_filesize?></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>
