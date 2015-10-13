<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script src="<?php echo base_url('static/js/ajaxfileupload.js');?>" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
    // 选择省
    $("select[name=driver_province]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=driver_city]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + fetch_class + '/ajax_get_region', {id: id}, function(json) {
            if (json.code == 'success') {
                var option = '<option value="0">请选择市</option>';
                for (var i=0; i<json.data.length; i++) {
                    option += '<option value="'+json.data[i].id+'">'+json.data[i].region_name+'</option>';
                }

                $("select[name=driver_city]").html(option);
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });
});

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
    <form action="<?php echo site_url(''.$this->appfolder.'/driver/act_edit_data')?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100">角色：</td>
                <td>
                    <select name="driver_role">
                        <option value="driver" <?php if ($data['driver_role'] == 'driver') { echo 'selected';}?>>司机</option>
                        <option value="owner" <?php if ($data['driver_role'] == 'owner') { echo 'selected';}?>>车主</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>司机姓名：</td>
                <td>
                    <input type="text" class="txt" name="driver_name" value="<?php echo $data['driver_name']?>">
                </td>
            </tr>
            <tr>
                <td>登陆名：</td>
                <td>
                    <input type="text" class="txt" name="login_name" value="<?php echo $data['login_name']?>">
                </td>
            </tr>
            <tr>
                <td>登陆密码：</td>
                <td>
                    <input type="password" class="txt" name="login_pwd" value="<?php echo $data['login_pwd']?>">
                </td>
            </tr>
            <tr>
                <td>呢称：</td>
                <td>
                    <input type="text" class="txt" name="driver_nick_name" value="<?php echo $data['driver_nick_name']?>">
                </td>
            </tr>
            <tr>
                <td>性别：</td>
                <td>
                    <select name="driver_sex">
                        <option value="男" <?php if ($data['driver_sex'] == '男') { echo 'selected';}?>>男</option>
                        <option value="女" <?php if ($data['driver_sex'] == '女') { echo 'selected';}?>>女</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>签名：</td>
                <td>
                    <input type="text" class="txt" name="driver_signature" value="<?php echo $data['driver_signature']?>">
                </td>
            </tr>
            <tr>
                <td>所在城市</td>
                <td>
                    <select name="driver_province" style="width: auto;">
                        <?php echo $get_region_options?>
                    </select>
                    <select name="driver_city" style="width: auto;">
                        <?php echo $get_city_region_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>手机号码：</td>
                <td>
                    <input type="text" class="txt" name="driver_mobile" value="<?php echo $data['driver_mobile']?>">
                </td>
            </tr>
            <tr>
                <td>其他电话：</td>
                <td>
                    <input type="text" class="txt" name="driver_tel" value="<?php echo $data['driver_tel']?>">
                </td>
            </tr>
            <tr>
                <td>身份证号码：</td>
                <td>
                    <input type="txt" class="txt" id="driver_card_num" name="driver_card_num" value="<?php echo $data['driver_card_num']?>">
                </td>
            </tr>
            <tr>
                <td>驾驶证号码：</td>
                <td>
                    <input type="txt" class="txt" id="driver_license" name="driver_license" value="<?php echo $data['driver_license']?>">
                </td>
            </tr>
            <tr>
                <td>头像照片：</td>
                <td>
                    <input type="file" id="driver_head_icon_img" name="driver_head_icon_img" onchange="return ajaxFileUpload(this.id)">
                    <?php if ($data['driver_head_icon_http_file']) {?>
                    <span>
                        <a href="<?php echo $data['driver_head_icon_http_file']?>" target="_blank">
                            <img style="padding: 5px;" src="<?php echo $data['driver_head_icon_http_file']?>" width="100" height="100">
                        </a>
                    </span>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>身份证照片：</td>
                <td>
                    <input type="file" id="driver_card_icon_img" name="driver_card_icon_img" onchange="return ajaxFileUpload(this.id)">
                    <?php if ($data['driver_card_icon_http_file']) {?>
                    <span>
                        <a href="<?php echo $data['driver_card_icon_http_file']?>" target="_blank">
                            <img style="padding: 5px;" src="<?php echo $data['driver_card_icon_http_file']?>" width="100" height="100">
                        </a>
                    </span>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>驾驶证照片：</td>
                <td>
                    <input type="file" id="driver_license_icon_img" name="driver_license_icon_img" onchange="return ajaxFileUpload(this.id)">
                    <?php if ($data['driver_license_icon_http_file']) {?>
                    <span>
                        <a href="<?php echo $data['driver_license_icon_http_file']?>" target="_blank">
                            <img style="padding: 5px;" src="<?php echo $data['driver_license_icon_http_file']?>" width="100" height="100">
                        </a>
                    </span>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>行驶证照片：</td>
                <td>
                    <input type="file" id="driver_vehicle_license_icon_img" name="driver_vehicle_license_icon_img" onchange="return ajaxFileUpload(this.id)">
                    <?php if ($data['driver_vehicle_license_icon_http_file']) {?>
                    <span>
                        <a href="<?php echo $data['driver_vehicle_license_icon_http_file']?>" target="_blank">
                            <img style="padding: 5px;" src="<?php echo $data['driver_vehicle_license_icon_http_file']?>" width="100" height="100">
                        </a>
                    </span>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>司机照片：</td>
                <td>
                    <input type="file" id="driver_pic_img" name="driver_pic_img" onchange="return ajaxFileUpload(this.id)">
                    <?php if ($data['driver_pic_http_file']) {?>
                    <span>
                        <a href="<?php echo $data['driver_pic_http_file']?>" target="_blank">
                            <img style="padding: 5px;" src="<?php echo $data['driver_pic_http_file']?>" width="100" height="100">
                        </a>
                    </span>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td>
                    <select name="driver_status" style="width: auto;">
                        <option value="1" <?php if ($data['driver_status'] == 1) { echo 'selected';}?>>有效</option>
                        <option value="2" <?php if ($data['driver_status'] == 2) { echo 'selected';}?>>无效</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>认证状态：</td>
                <td>
                    <select name="driver_type" style="width: auto;">
                        <?php
                        foreach ($config_driver_type as $key => $value) {
                        ?>
                        <option value="<?php echo $key?>" <?php if ($data['driver_type'] == $key) { echo 'selected';}?>><?php echo $value?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>当前积分：</td>
                <td><input type="text" class="txt" name="driver_score" value="<?php echo $data['driver_score']?>"></td>
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