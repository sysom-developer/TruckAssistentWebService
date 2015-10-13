<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
	// 解决浏览器自动记录表单数据 
	$("#edit_form")[0].reset();

	$("input[name=nav_id]").click(function() {
		var nav_id = $(this).val();
		var checkdStatus = $(this).prop("checked");

		if (checkdStatus == true) {
			$("input[other_name=menu_id_"+nav_id+"]").prop("checked", true);
			$(this).prop("checked", true);
		} else {
			$("input[other_name=menu_id_"+nav_id+"]").prop("checked", false);
			$(this).prop("checked", false);
		}
	});
});
</script>

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
	<form id="edit_form" name="edit_form" action="<?php echo site_url(''.$this->appfolder.'/admin/act_edit_data')?>" method="post">
	<input type="hidden" name="id" value="<?php echo $id?>">
	<input type="hidden" name="former_username" value="<?php echo $data['username']?>">
	<div class="forms_box">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <?php
            if ($data['is_super_admin'] != 1) {
            ?>
			<tr>
				<td>所属部门：</td>
				<td>
					<select name="depart_id">
                        <?php echo $department_options?>
                    </select>
				</td>
			</tr>
            <?php
            }
            ?>
			<tr>
				<td width="100">用户名：</td>
				<td><input type="text" class="txt" name="new_username" value="<?php echo $data['username']?>" /></td>
			</tr>
			<tr>
				<td>密码：</td>
				<td><input type="password" class="txt" name="new_password" value="" /></td>
			</tr>
			<tr>
				<td>确认密码：</td>
				<td><input type="password" class="txt" name="new_confirm_password" value="" /></td>
			</tr>
			<tr>
				<td>设置权限：</td>
				<td>
					<table border="0" cellspacing="3" cellpadding="5">
						<?php 
						foreach ($navigation as $key => $n_data) {
						?>
						<tr>
							<td><input type="checkbox" name="nav_id" value="<?php echo $key?>">&nbsp;<?php echo $n_data?></td>					
						</tr>
							<?php 
							foreach ($menu[$key] as $k => $v) {

							?>
							<tr>
								<td>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" other_name="menu_id_<?php echo $key?>" name="controller_name[]" value="<?php echo $v['controller_name']?>" <?php if ($data['is_super_admin'] == 1 || in_array($v['controller_name'], $data['controller_name'])) { echo 'checked';}?>>&nbsp;<?php echo $v['menu_name']?>
								</td>
							</tr>
						<?php
							}
						}
						?>
					</table>
				</td>				
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" class="btn" value="确 认" />
			<input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回" />
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>
</div>
</body>
</html>