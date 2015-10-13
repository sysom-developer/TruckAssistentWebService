(function() {
    // 获取验证码
    window.get_sms_seccode = function(mobile_phone, prefix, _callback) {
        $.post(apppath + '/smsseccode/get_sms_seccode', {mobile_phone: mobile_phone, prefix: prefix}, function(json) {
            if("undefined" !== typeof _callback) return _callback(json);
        }, 'json');
    };
    // 验证验证码
    window.verify_sms_seccode = function(mobile_phone, seccode, prefix, _callback) {
        $.post(apppath + '/smsseccode/ajax_verify_sms_seccode', {mobile_phone: mobile_phone, seccode: seccode, prefix: prefix}, function(json) {
            if("undefined" !== typeof _callback) return _callback(json);
        }, 'json');
    };

    // 获取管理码
    window.get_manager_seccode = function(company_id, prefix, _callback) {
        $.post(apppath + '/smsseccode/get_manager_seccode', {company_id: company_id, prefix: prefix}, function(json) {
            if("undefined" !== typeof _callback) return _callback(json);
        }, 'json');
    };

    // 验证手机号码
    window.verify_mobile_phone = function(mobile_phone) {
        var reg = !!mobile_phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
        if (reg == false) {
            return false;
        }

        return true;
    };

    // 字母和数字
    window.verify_password = function(string) {
        if (string.length < 6) {
            return false;
        }

        var jgpattern =/^[A-Za-z0-9]+$/;
        if (!jgpattern.test(string)) {
            return false;
        }

        return true;
    }

    window.placeholder = function() {
        $(".placeholder").focus(function() {
            var val = $(this).attr('val');
            var value = $(this).val();

            if (value == val) {
                $(this).val('');
            }
        }).blur(function() {
            var val = $(this).attr('val');
            var value = $(this).val();

            if (value == '') {
                $(this).val(val);
            }
        });
    };
})(window,jQuery);