<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script src="<?php echo base_url('static/js/ajaxfileupload.js');?>" type="text/javascript"></script>

<script type="text/javascript">
function ajaxFileUpload(file_id) {
    $.ajaxFileUpload({
        cache:false,
        url:'<?php echo site_url("'+appfolder+'/upload_file/index/?file_id='+file_id+'")?>',
        secureuri:false,
        fileElementId:file_id,
        dataType: 'json',
        success: function (data) {
            if (data.status != 1) {
                $("#"+file_id).after("<span>上传失败，"+data.data+"</span>");
            } else {
                $("#"+file_id).next('span').remove();
                $("#"+file_id).after(
                    "<span> \
                        <input type='hidden' name='"+file_id+"_attachment_id' value='"+data.data.attachment_id+"'> \
                        <a href='" + data.data.http_file + "' target='_blank'> \
                            <img src='"+data.data.http_file+"' width='100' height='100'> \
                        </a> \
                    </span>");
            }
        },
        error: function () {
            alert('图片上传失败，请重新操作');
        }
    });

    return true;
}
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
    <form action="<?php echo site_url(''.$this->appfolder.'/vehicle/act_edit_data')?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100">所属司机：</td>
                <td>
                    <select name="driver_id">
                        <?php echo $get_driver_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>车牌号：</td>
                <td>
                    <input type="text" class="txt" name="vehicle_card_num" value="<?php echo $data['vehicle_card_num']?>">
                </td>
            </tr>
            <tr>
                <td>发动机号：</td>
                <td>
                    <input type="text" class="txt" name="vehicle_engine" value="<?php echo $data['vehicle_engine']?>">
                </td>
            </tr>
            <tr>
                <td>车头照：</td>
                <td>
                    <input type="file" id="vehicle_head_icon_img" name="vehicle_head_icon_img" onchange="return ajaxFileUpload(this.id)">
                    <?php if ($data['vehicle_head_icon_http_file']) {?>
                    <span>
                        <a href="<?php echo $data['vehicle_head_icon_http_file']?>" target="_blank">
                            <img style="padding: 5px;" src="<?php echo $data['vehicle_head_icon_http_file']?>" width="100" height="100">
                        </a>
                    </span>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>类型：</td>
                <td>
                    <select name="vehicle_type">
                        <?php echo $get_vehicle_type_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>宽（米）：</td>
                <td>
                    <input type="text" class="txt" name="vehicle_width" value="<?php echo $data['vehicle_width']?>">
                </td>
            </tr>
            <tr>
                <td>长（米）：</td>
                <td>
                    <select name="vehicle_length">
                        <?php echo $get_vehicle_length_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>高（米）：</td>
                <td>
                    <input type="text" class="txt" name="vehicle_height" value="<?php echo $data['vehicle_height']?>">
                </td>
            </tr>
            <tr>
                <td>载重（吨）：</td>
                <td>
                    <select name="vehicle_load">
                        <?php echo $get_vehicle_load_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>VIN码：</td>
                <td>
                    <input type="text" class="txt" name="vehicle_vin" value="<?php echo $data['vehicle_vin']?>">
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td>
                    <select name="vehicle_status" style="width: auto;">
                        <option value="1" <?php if ($data['vehicle_status'] == 1) { echo 'selected';}?>>有效</option>
                        <option value="2" <?php if ($data['vehicle_status'] == 2) { echo 'selected';}?>>无效</option>
                    </select>
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