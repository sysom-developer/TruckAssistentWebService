<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />

<script src="<?php echo base_url('static/js/ajaxfileupload.js');?>" type="text/javascript"></script>

<style type="text/css">
.opacity_file{
    opacity: 0;
    width: 256px;
    height: 45px;
    left: 145px;
    top: 0;
    position: absolute;
}
</style>

<script type="text/javascript">
$(function() {
    $(".member-setting-submit").click(function() {
        $(".errormessage").hide();
        $(".sucessmessage").hide();

        $.post(apppath + fetch_class + '/ajax_do_setting', $("form[name=member_setting_form]").serialize(), function(json) {
            if (json.code == 'success') {
                $(".sucessmessage").show();
                window.setTimeout("window.location.reload();", 1000);
            } else {
                $(".errormessage").html(json.code);
                $(".errormessage").show();

                return false;
            }
        }, 'json');

        return false;
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
                $("#shipper_head_icon_show").attr("src", data.data.http_file);
                $("#"+file_id).next('span').remove();
                $("#"+file_id).after(
                    "<span> \
                        <input type='hidden' name='"+file_id+"_attachment_id' value='"+data.data.attachment_id+"'> \
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

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="container">
    <form name="member_setting_form" action="<?php echo site_url($this->appfolder.'/member/do_setting')?>" method="post">
    <div class="usercenter">
        <div class="errormessage" style="display: none;">新密码两次输入不一致</div>
        <div class="sucessmessage" style="display: none;">已成功修改个人资料</div>
        <dl>
            <dd>登录名</dd>
            <dt style="font-size: 14px; color: #999;">
                <?php echo $this->shipper_info['login_name']?>
            </dt>
        </dl>
        <dl>
            <dd>昵称</dd>
            <dt><input name="shipper_name" type="text" value="<?php echo $this->shipper_info['shipper_name']?>" class="input"></dt>
        </dl>
        <dl>
            <dd>个人头像</dd>
            <dt class="userpic">
                <span>
                    <img id="shipper_head_icon_show" name="shipper_head_icon_show" src="<?php echo $this->shipper_info['shipper_head_icon_http_file']?>" width="45" height="45">
                </span>
                <span>
                    <input type="file" id="shipper_head_icon_img"name="shipper_head_icon_img" onchange="return ajaxFileUpload(this.id)" class="opacity_file" />
                    <input name="upfile" type="button" value="上传头像" class="upfileimg" id="uploadimg">
                </span>
            </dt>
        </dl>
        <dl class="line">
            <dd>&nbsp;</dd>
            <dt style="font-size: 14px; color: #999;">密码不修改请留空</dt>
        </dl>
        <dl>
            <dd>当前密码</dd>
            <dt><input name="former_password" type="password" value="" class="input" ></dt>
        </dl>
        <dl>
            <dd>新密码</dd>
            <dt><input name="password" type="password" value="" class="input"></dt>
        </dl>
        <dl>
            <dd>确认新密码</dd>
            <dt><input name="confirm_password" type="password" value="" class="input"></dt>
        </dl>
        <dl class="line">
            <dd>公司名称</dd>
            <dt style="font-size: 14px; color: #999;"><?php echo $this->shipper_info['shipper_company_data']['shipper_company_name']?></dt>
        </dl>
        <dl>
            <dd>公司地址</dd>
            <dt><input name="shipper_company_addr" type="text" value="<?php echo $this->shipper_info['shipper_company_data']['shipper_company_addr']?>" class="input"></dt>
        </dl>
        <dl>
            <dd>公司简介</dd>
            <dt><input name="shipper_company_desc" type="text" value="<?php echo $this->shipper_info['shipper_company_data']['shipper_company_desc']?>" class="input"></dt>
        </dl>
        <dl>
            <dd></dd>
            <dt><input name="submit" type="submit" value="保存" class="refer member-setting-submit"></dt>
        </dl>
     </div>
    </form>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>