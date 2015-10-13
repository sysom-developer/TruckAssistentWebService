<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />

<script type="text/javascript">
$(function() {
    window.placeholder();

    $('input[name=login_name], input[name=login_pwd]').focus(function() {
        $(this).css('color', '#fff');
    });

    $("#remember_auto_login").click(function() {
        if ($(this).attr("checked") == "checked") {
            $("#check").addClass("cancelcheck");
            $("#remember_auto_login").attr("checked", false);
        } else {
            $("#check").removeClass("cancelcheck");
            $("#remember_auto_login").attr("checked", true);
        }
    });

    $(".register-url").click(function() {
        window.location.href = apppath + "register";
    });

    $(".login-url").click(function() {
        $.post(apppath + fetch_class + '/ajax_do_login', $("form[name=login_form]").serialize(), function(json) {
            if (json.code == 'success') {
                window.location.href = apppath+"vehicle/vehicle_list/?order_type=997";
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');

        return false;
    });
});
</script>

<body style="background:#181d29;">

<div class="denglu">
    <form method="post" name="login_form" action="<?php echo site_url(''.$this->appfolder.'/login/do_login')?>">
        <h2>欢迎您货主，请登陆</h2>
        <p>
            <span>
                帐号 <input name="login_name" type="text" val="请输入账号" value="请输入账号" class="dlinput placeholder">
            </span>
        </p>
        <p>
            <span>
                密码 <input name="login_pwd" type="password" val="输入6~20位密码" value="输入6~20位密码" class="dlinput placeholder">
            </span>
        </p>
        <p>
            <input type="submit" class="dlbutton login-url" value="登陆" ><input type="button" class="zcbutton register-url" value="注册" >
        </p> 
        <p>
            <label style="color:#308ab0; position:relative;">
                <span id="check"></span>
                <input id="remember_auto_login" name="remember_auto_login" type="checkbox" value="1" checked/>下次自动登陆
            </label>
            <label style="text-align:right;color:#91969c;">
                <a href="<?php echo site_url($this->appfolder.'/forget_pwd')?>">忘记密码？</a  >
            </label>
        </p>
    </form>
</div>

</body>
<?php $this->load->view(''.$this->appfolder.'/footer_view');?>