<?php $this->load->view($this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('/static/css/'.$this->appfolder.'/app_web.css')?>">
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/global.js')?>"></script>

<script type="text/javascript">
var app_download_path = "<?php echo site_url('appdownload/TruckManager-release.apk')?>";
$(function() {
    window.placeholder();

    $('.invite-reg-submit').click(function() {
        $.post(apppath + fetch_class + '/ajax_do_reg', $("form[name=invite_reg_form]").serialize(), function(json) {
            if (json.code == 'success') {
                window.location.href = app_download_path;
            } else {
                alert(json.code);
                return false;
            }
        }, 'json');

        return false;
    });

    // 验证码
    $(".invite-reg-get-seccode").click(function() {
        var mobile_phone = $("input[name=mobile_phone").val();
        var prefix = 'invite_register';

        $.post(apppath + '/smsseccode/get_sms_seccode', {mobile_phone: mobile_phone, prefix: prefix}, function(json) {
            if (json.code == 'success') {
                time($(".invite-reg-get-seccode")[0]);
            }
        }, 'json');

        return false;
    });

    function is_weixn(){
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            return true;
        } else {
            return false;
        }
    }

    var is_weixin = is_weixn();
    if (is_weixin == true) {
        $(".mask-html").show();
    }
});

// 倒计时
var wait = 300;
function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled");            
        o.innerHTML="获取验证码";
        wait = 300;
    } else {
        o.setAttribute("disabled", true);
        o.innerHTML="( " + wait + " )";
        wait--;
        setTimeout(function() {
            time(o)
        }, 1000);
    }
}
</script>

<body style="background:#0f1320;">
    <div class="mask mask-html" style="display: none;">
        <img src="<?php echo static_url('static/images/'.$this->appfolder.'/mask.png')?>"/>
        <div class="mask_arrow">
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/prompt.png')?>"/>
        </div>
        <div class="mask_text">
            <p>微信无法打开下载<br/>点击右上角<br/>“浏览器打开”吧</p>
        </div>
    </div>
    
    <form name="invite_reg_form" action="" method="post">
    <input type="hidden" name="invite_decode" value="<?php echo $invite_decode?>">
    <div class="invitation">
        <img src="<?php echo static_url('static/images/'.$this->appfolder.'/invitation.png')?>" />
            <div class="inv_input">
                <ul>
                    <li><input type="text" name="mobile_phone" placeholder="请输入您的手机号码" value=""></li>
                    <li><input type="text" name="seccode" placeholder="输入验证码" style="width:70%;" value=""></li>
                    <li><input type="password" name="password" placeholder="设置登录密码" value=""></li>
                </ul>
                <a href="javascript:;" class="invite-reg-get-seccode">获取验证码</a>
            </div>
    </div>

    <div class="inv_text">
        <a href="javascript:;" class="invite-reg-submit">注册并下载途好运App奖励10个好运币</a>
    </div>
    </form>
</body>

<?php $this->load->view($this->appfolder.'/footer_view');?>