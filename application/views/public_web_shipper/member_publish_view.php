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
    window.placeholder();

    $('.member-publish-submit').click(function() {
        $(".errormessage").hide();
        $(".sucessmessage").hide();

        $.post(apppath + fetch_class + '/ajax_do_member_publish', $("form[name=member_publish_form]").serialize(), function(json) {
            if (json.code == 'success') {
                $(".sucessmessage").show();
                window.setTimeout("window.location.reload();", 1000);
            } else {
                $(".errormessage").html(json.code);
                $(".errormessage").show();

                window.setTimeout(function() {
                    $(".errormessage").hide();
                    $(".sucessmessage").hide();
                }, 2000);

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
    <form name="member_publish_form" action="<?php echo site_url($this->appfolder.'/member/ajax_do_member_publish')?>" method="post">
    <input type="hidden" name="company_id" value="<?php echo $this->shipper_info['company_id']?>">
    <div class="usercenter">
        <div class="errormessage" style="display: none;">操作失败</div>
        <div class="sucessmessage" style="display: none;">操作成功</div>
        <dl>
            <dd>手机号码</dd>
            <dt style="font-size: 14px; color: #999;">
                <input name="login_name" type="text" class="input placeholder" val="请输入登录名" value="请输入登录名">
            </dt>
        </dl>
        <dl>
            <dd>密码</dd>
            <dt><input name="password" type="password" value="" class="input"></dt>
        </dl>
        <dl>
            <dd></dd>
            <dt><input name="submit" type="submit" value="保存" class="refer member-publish-submit"></dt>
        </dl>
     </div>
    </form>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>