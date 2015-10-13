<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />

<script type="text/javascript">
$(function() {
    window.placeholder();

    // 手机号码
    $("input[name=mobile_phone]").focus(function() {
        $(this).removeClass("repeatinput").addClass("input");
    });
    $("input[name=mobile_phone]").blur(function() {
        var mobile_phone = $(this).val();

        if (window.verify_mobile_phone(mobile_phone) == false) {
            $(this).removeClass("input").addClass("repeatinput");
        }
    });

    // 验证码
    $("input[name=get_sms_seccode]").click(function() {
        var mobile_phone = $("input[name=mobile_phone").val();

        window.get_sms_seccode_callback = function(json) {
            if (json.code == 'success') {
                time($("input[name=get_sms_seccode]")[0]);
            } else {
                alert(json.code);
                return false;
            }
        };
        window.get_sms_seccode(mobile_phone, 'forget_pwd', window.get_sms_seccode_callback);
    });
    $("input[name=seccode]").blur(function() {
        window.verify_sms_seccode_callback = function(json) {
            if (json.code == 'success') {
                $("input[name=seccode]").removeClass("inputcode_repeatinput").addClass("inputcode");
            } else {
                $("input[name=seccode]").removeClass("inputcode").addClass("inputcode_repeatinput");

                alert(json.code);
                return false;
            }
        };

        var mobile_phone = $("input[name=mobile_phone").val();
        var seccode = $(this).val();
        window.verify_sms_seccode(mobile_phone, seccode, 'forget_pwd', window.verify_sms_seccode_callback);
    });

    // 密码
    $("input[name=password]").blur(function() {
        var default_text = '请输入新密码';
        var password = $(this).val();

        if (password == default_text) {
            $(this).removeClass("input").addClass("repeatinput");
            $("input[name=confirm_password]").removeClass("input").addClass("repeatinput");

            return false;
        }

        if (window.verify_password(password) == false) {
            $(this).removeClass("input").addClass("repeatinput");

            return false;
        } else {
            $(this).removeClass("repeatinput").addClass("input");
        }

        return true;
    });

    $(".forget-pwd-url").click(function() {
        $.post(apppath + fetch_class + '/reset_password', $("form[name=forget_pwd_form]").serialize(), function(json) {
            if (json.code == 'success') {
                window.location.href = apppath+"/login";
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');

        return false;
    });
});

// 倒计时
var wait = 300;
function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled");            
        o.value="获取验证码";
        wait = 300;
    } else {
        o.setAttribute("disabled", true);
        o.value="( " + wait + " )";
        wait--;
        setTimeout(function() {
            time(o)
        }, 1000);
    }
}
</script>

<body>
<div class="container">
    <form action="" method="post" name="forget_pwd_form">
    <div class="usercenter">
        <h2>找回密码</h2>
        <dl style="padding-top:30px;">
            <dd>手机号码</dd>
            <dt>
                <input name="mobile_phone" val="请输入手机号码" value="请输入手机号码" type="text" class="input placeholder">
            </dt>
        </dl>
        <dl>
            <dd>验证码</dd>
            <dt>
                <input name="seccode" val="请输入验证码" value="请输入验证码" type="text" class="inputcode placeholder"><input name="get_sms_seccode" type="button" value="获取验证码" class="checkcode"> 
            </dt>
        </dl>
        <dl>
            <dd>新密码</dd>
            <dt>
                <input name="password" type="password" class="input">
            </dt>
        </dl>
        <dl style="padding-top:30px;">
            <dd></dd>
            <dt>
                <input name="submit" type="submit" value="确定" class="refer forget-pwd-url">
            </dt>
        </dl>
    </div>
    </form>
</div>        
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>