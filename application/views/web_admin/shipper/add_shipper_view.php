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
    <form action="<?php echo site_url(''.$this->appfolder.'/shipper/act_add_data')?>" method="post" enctype="multipart/form-data">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="200">所属货运公司：</td>
                <td>
                    <select name="company_id">
                        <?php 
                        foreach ($shipper_company_data_list as $value) {
                        ?>
                        <option value="<?php echo $value['id']?>"><?php echo $value['shipper_company_name']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>货主名称：</td>
                <td>
                    <input type="text" class="txt" name="shipper_name" value="">
                </td>
            </tr>
            <tr>
                <td>货主后台登陆用户名：</td>
                <td>
                    <input type="text" class="txt" name="login_name" value="">
                </td>
            </tr>
            <tr>
                <td>货主后台登陆密码：</td>
                <td>
                    <input type="password" class="txt" name="login_pwd" value="">
                </td>
            </tr>
            <tr>
                <td>货主电话：</td>
                <td>
                    <input type="text" class="txt" name="shipper_mobile" value="">
                </td>
            </tr>
            <tr>
                <td>货主身份证号：</td>
                <td>
                    <input type="text" class="txt" name="shipper_card_num" value="">
                </td>
            </tr>
            <tr>
                <td>货主类型</td>
                <td>
                    <select name="shipper_type">
                        <option value="1" selected>货主</option>
                        <option value="2">中介</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>是否公司账户：</td>
                <td>
                    <select name="is_admin">
                        <option value="0" selected>不是</option>
                        <option value="1">是</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>货主头像：</td>
                <td>
                    <input type="file" id="shipper_head_icon_img" name="shipper_head_icon_img" onchange="return ajaxFileUpload(this.id)">
                </td>
            </tr>
            <tr>
                <td>公司或跟人照片：</td>
                <td>
                    <input type="file" id="shipper_pic_img" name="shipper_pic_img" onchange="return ajaxFileUpload(this.id)">
                </td>
            </tr>
            <tr>
                <td>身份证照片：</td>
                <td>
                    <input type="file" id="shipper_card_pic_img" name="shipper_card_pic_img" onchange="return ajaxFileUpload(this.id)">
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td>
                    <select name="shipper_status" style="width: auto;">
                        <option value="1" selected>有效</option>
                        <option value="2">无效</option>
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