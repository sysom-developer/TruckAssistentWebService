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
    <form action="<?php echo site_url(''.$this->appfolder.'/product_score/act_edit_data')?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100">名称：</td>
                <td>
                    <input type="text" class="txt" name="product_name" value="<?php echo $data['product_name']?>">
                </td>
            </tr>
            <tr>
                <td>描述：</td>
                <td>
                    <textarea name="product_desc"><?php echo $data['product_desc']?></textarea>
                </td>
            </tr>
            <tr>
                <td>图片：</td>
                <td>
                    <input type="file" id="product_img" name="product_img" onchange="return ajaxFileUpload(this.id)">
                    <?php if ($data['product_img_http_file']) {?>
                    <span>
                        <a href="<?php echo $data['product_img_http_file']?>" target="_blank">
                            <img style="padding: 5px;" src="<?php echo $data['product_img_http_file']?>" width="100" height="100">
                        </a>
                    </span>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>兑换类型：</td>
                <td>
                    <select name="exchange_type">
                        <option value="1" <?php if ($data['exchange_type'] == 1) { echo 'selected';}?>>司机</option>
                        <option value="2" <?php if ($data['exchange_type'] == 2) { echo 'selected';}?>>货运公司</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>所需积分：</td>
                <td>
                    <input type="text" class="txt" name="exchange_num" value="<?php echo $data['exchange_num']?>">
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td>
                    <select name="status" style="width: auto;">
                        <option value="1" <?php if ($data['status'] == 1) { echo 'selected';}?>>有效</option>
                        <option value="2" <?php if ($data['status'] == 2) { echo 'selected';}?>>无效</option>
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