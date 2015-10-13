<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<body>
<div class="warrper">
<div class="content">

	<?php $this->load->view(''.$this->appfolder.'/path_view');?>
	
	<div class="shop">
		<div class="shop_content">
			<div class="search_box">
				<p><strong><?php echo $path_name?></strong></p>
			</div>
		</div>
	</div>
	<div class="forms_box">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="110">ID：</td>
				<td><?php echo $data['id']?></td>
			</tr>
			<?php
            if ($data['is_super_admin'] != 1) {
            ?>
            <tr>
				<td>所属部门：</td>
				<td><?php echo $data['depart_data']['depart_name']?></td>
			</tr>
            <?php
            }
            ?>
			<tr>
				<td>用户名：</td>
				<td><?php echo $data['username']?></td>
			</tr>
			<tr>
				<td>创建时间：</td>
				<td><?php echo date("Y-m-d H:i:s", $data['cretime'])?></td>
			</tr>
			<tr>
				<td>修改时间：</td>
				<td><?php echo date("Y-m-d H:i:s", $data['updatetime'])?></td>
			</tr>
			<tr>
				<td>是否是超级管理员：</td>
				<td><?php echo $data['is_super_admin'] == 1 ? "<font color='green'>是</font>" : "<font color='red'>否</font>"?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回" />
				</td>
			</tr>
		</table>
	</div>
</div>
</div>
</body>
</html>