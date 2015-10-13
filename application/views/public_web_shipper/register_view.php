<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />

<script type="text/javascript">
$(function() {
    window.placeholder();

    // 手机号码
    $("input[name=mobile_phone]").focus(function() {
        $(".regisererror").hide();

        $(this).removeClass("repeatinput").addClass("input");
    });
    $("input[name=mobile_phone]").blur(function() {
        $(".regisererror").hide();

        var mobile_phone = $(this).val();

        if (window.verify_mobile_phone(mobile_phone) == false) {
            $(".regisererror").html('手机号码输入错误');
            $(".regisererror").show();
            $(this).removeClass("input").addClass("repeatinput");
        }
    });

    // 验证码
    $("input[name=get_sms_seccode]").click(function() {
        $(".regisererror").hide();

        var mobile_phone = $("input[name=mobile_phone").val();

        window.get_sms_seccode_callback = function(json) {
            if (json.code == 'success') {
                time($("input[name=get_sms_seccode]")[0]);
            } else {
                $(".regisererror").html(json.code);
                $(".regisererror").show();
            }
        };
        window.get_sms_seccode(mobile_phone, 'register', window.get_sms_seccode_callback);
    });
    $("input[name=seccode]").blur(function() {
        $(".regisererror").hide();

        window.verify_sms_seccode_callback = function(json) {
            if (json.code == 'success') {
                $("input[name=seccode]").removeClass("seccode_repeatinput").addClass("inputcode");
            } else {
                $(".regisererror").html(json.code);
                $(".regisererror").show();
                $("input[name=seccode]").removeClass("checkcode").addClass("seccode_repeatinput");
            }
        };

        var mobile_phone = $("input[name=mobile_phone").val();
        var seccode = $(this).val();
        window.verify_sms_seccode(mobile_phone, seccode, 'register', window.verify_sms_seccode_callback);
    });

    // 密码
    $("input[name=password]").blur(function() {
        $(".regisererror").hide();

        var password = $(this).val();
        var confirm_password = $("input[name=confirm_password]").val();

        if (password != confirm_password) {
            $(".regisererror").html('两次输入的密码不一致');
            $(".regisererror").show();
            $(this).removeClass("input").addClass("repeatinput");

            return false;
        }

        if (window.verify_password(password) == false) {
            $(".regisererror").html('请输入6位或以上的数字或英文');
            $(".regisererror").show();
            $(this).removeClass("input").addClass("repeatinput");

            return false;
        } else {
            $(this).removeClass("repeatinput").addClass("input");
        }

        return true;
    });
    // 确认密码
    $("input[name=confirm_password]").blur(function() {
        $(".regisererror").hide();

        var password = $("input[name=password]").val();
        var confirm_password = $(this).val();

        if (password != confirm_password) {
            $(".regisererror").html('两次输入的密码不一致');
            $(".regisererror").show();
            $(this).removeClass("input").addClass("repeatinput");
            $("input[name=password]").removeClass("input").addClass("repeatinput");

            return false;
        }

        if (window.verify_password(confirm_password) == false) {
            $(".regisererror").html('请再次输入新的密码');
            $(".regisererror").show();
            $(this).removeClass("input").addClass("repeatinput");

            return false;
        } else {
            $(this).removeClass("repeatinput").addClass("input");
            $("input[name=password]").removeClass("repeatinput").addClass("input");
        }

        return true;
    });

    // 公司名称
    $("input[name=company_name]").blur(function() {
        $(".regisererror").hide();

        var default_text = '请输入公司名称';
        var company_name = $(this).val();
        if (company_name == default_text || company_name == '') {
            $(".regisererror").html('请输入公司名称');
            $(".regisererror").show();
            $(this).removeClass("input").addClass("repeatinput");

            return false;
        } else {
            $(this).removeClass("repeatinput").addClass("input");
        }

        return true;
    });
    // 公司地址
    $("input[name=company_address]").blur(function() {
        $(".regisererror").hide();

        var default_text = '请输入公司地址';
        var company_address = $(this).val();
        if (company_address == default_text || company_address == '') {
            $(".regisererror").html('请输入公司地址');
            $(".regisererror").show();
            $(this).removeClass("input").addClass("repeatinput");

            return false;
        } else {
            $(this).removeClass("repeatinput").addClass("input");
        }

        return true;
    });

    $(".register-submit").click(function() {
        $(".regisererror").hide();

        $.post(apppath + fetch_class + '/ajax_do_reg', $("form[name=register_form]").serialize(), function(json) {
            if (json.code == 'success') {
                window.location.href = apppath+"";
            } else {
                $(".regisererror").html(json.code);
                $(".regisererror").show();

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
    <form name="register_form" action="<?php echo site_url(''.$this->appfolder.'/register/ajax_do_reg')?>" method="post">
    <div class="usercenter">
        
        <?php $this->load->view(''.$this->appfolder.'/register_top_view');?>

        <dl class="line">
            <dd>
                <span style="color: #FF0000; font-weight: bold;">*</span>
                手机号码
            </dd>
            <dt>
                <input name="mobile_phone" val="请输入手机号码" value="请输入手机号码" type="text" class="input placeholder">
            </dt>
        </dl>
        <dl>
            <dd>
                <span style="color: #FF0000; font-weight: bold;">*</span>
                验证码
            </dd>
            <dt>
                <input name="seccode" val="请输入验证码" value="请输入验证码" type="text" class="inputcode placeholder">
                <input name="get_sms_seccode" type="button" value="获取验证码" class="checkcode" style="cursor: pointer;">
            </dt>
        </dl>
        <dl>
            <dd>
                <span style="color: #FF0000; font-weight: bold;">*</span>
                设置密码
            </dd>
            <dt>
                <input name="password" type="password" class="input">
            </dt>
        </dl>
        <dl>
            <dd>
                <span style="color: #FF0000; font-weight: bold;">*</span>
                确认密码
            </dd>
            <dt>
                <input name="confirm_password" type="password" class="input">
            </dt>
        </dl>
        <dl class="line">
            <dd>
                <span style="color: #FF0000; font-weight: bold;">*</span>
                公司名称
            </dd>
            <dt>
                <input name="company_name" type="text" val="请输入公司名称" value="请输入公司名称" class="input placeholder">
            </dt>
        </dl>
        <dl>
            <dd>
                <span style="color: #FF0000; font-weight: bold;">*</span>
                公司地址
            </dd>
            <dt>
                <input name="company_address" type="text" val="请输入公司地址" value="请输入公司地址" class="input placeholder">
            </dt>
        </dl>
        <dl>
            <dd></dd>
            <dt>
                <span style="font-size:16px;padding-left:60px;*padding-left:30px;">
                    <input name="is_agree" type="checkbox" value="1" checked/>
                    阅读并同意
                    <a href="javascript:;"><span style="color:#007de0">《软件许可及服务协议》</span></a>
                </span>
            </dt>
        </dl>

        <dl>
            <dd></dd>
            <dt style="*text-align:center;*padding-left:30px;">
                <input name="register_submit" type="submit" value="确定" class="refer register-submit">
            </dt>
        </dl>
    </div>
    </form>
</div>

</body>
<?php $this->load->view(''.$this->appfolder.'/footer_view');?>