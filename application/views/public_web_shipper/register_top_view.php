<script type="text/javascript">
$(function() {
    $("i[name=register_type_i]").click(function() {
        var register_type = $(this).find("input[name=register_type]").val();
        var url = apppath + "register";
        if (register_type == 2) {
            url = apppath + "register/company_user";
        }

        window.location.href = url;
    });
});
</script>

<div class="regisererror" style="display: none;"></div>
<div class="regisersucess" style="display: none;"></div>

<h2>请选择货主注册类型</h2>
<dl>
    <dd>
        <i name="register_type_i" <?php if ($this->router->fetch_method() == 'index') { echo 'class="on"';}?>><input name="register_type" type="radio" value="1" class="radioclass" checked/></i>
    </dd>
    <dt>新注册用户</dt>
</dl>
<dl>
    <dd>
        <i name="register_type_i" <?php if ($this->router->fetch_method() == 'company_user') { echo 'class="on"';}?>><input name="register_type" type="radio" value="2" class="radioclass"/></i>
    </dd>
    <dt>已注册公司用户</dt>
</dl>