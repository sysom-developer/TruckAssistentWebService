<script type="text/javascript">
$(function() {
    $(".add-car").click(function() {
        $(".editcar").show();

        $(".mask").show();
        $(".editorcontent").show();
        
        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });

    // 搜索车牌号码
    $("input[name=vehicle_card_num]").keyup(function() {
        $(".error-tip").hide();
        $(".autocomplete-item-data").hide();

        var vehicle_card_num = $(this).val();

        $(".vehicle-card-num-loading").show();

        $.post(apppath + fetch_class + '/ajax_search_vehicle_card_num', {vehicle_card_num: vehicle_card_num}, function(json) {
            $(".error-tip").css("background", "#f26b54").hide();
            if (json.code == 'success') {
                var html = '';

                if (json.data_list.length == 0 || json.data_list.length == undefined) {
                    $(".error-tip").find("span").html("没有查询到数据");
                    $(".error-tip").show();
                    $(".vehicle-card-num-loading").hide();

                    return false;
                }

                for (var i = json.data_list.length - 1; i >= 0; i--) {
                    html += "<a href='javascript:;' \
                    vehicle_card_num='"+json.data_list[i].vehicle_card_num+"' \
                    driver_name='"+json.data_list[i].driver_name+"' \
                    driver_mobile='"+json.data_list[i].driver_mobile+"' \
                    vehicle_type_id='"+json.data_list[i].type_id+"' \
                    vehicle_type='"+json.data_list[i].type_name+"' \
                    vehicle_length='"+json.data_list[i].vehicle_length+"'>"+json.data_list[i].item_data+"</a>";
                };
                $(".autocomplete-item-data").html(html);
                $(".autocomplete-item-data").show();
                $(".vehicle-card-num-loading").hide();
            } else {
                $(".error-tip").find("span").html(json.code);
                $(".error-tip").show();
                $(".vehicle-card-num-loading").hide();

                return false;
            }
        }, 'json');

        return false;
    });
    //选中标签
    $(".autocomplete-item-data").delegate("a", "click", function() {
        var vehicle_card_num = $(this).attr("vehicle_card_num");
        var driver_name = $(this).attr("driver_name");
        var driver_mobile = $(this).attr("driver_mobile");
        var vehicle_type_id = $(this).attr("vehicle_type_id");
        var vehicle_type = $(this).attr("vehicle_type");
        var vehicle_length = $(this).attr("vehicle_length");
        
        $("input[name=vehicle_card_num]").val(vehicle_card_num);
        $("input[name=driver_name]").val(driver_name);
        $("input[name=driver_mobile]").val(driver_mobile);
        $("input[name=vehicle_type_id]").val(vehicle_type_id);
        $("input[name=vehicle_type]").val(vehicle_type);
        $("input[name=vehicle_length]").val(vehicle_length);

        $(this).parent("div.autocomplete-item-data").hide();
    });

    $(".publish-vehicle-submit").click(function() {
        $(".error-tip").css("background", "#f26b54").hide();

        var order_type = $(this).attr("order_type");
        $("input[name=order_type]").val(order_type);

        $.post(apppath + 'vehicle/ajax_do_publish_vehicle', $("form[name=publish_vehicle_form]").serialize(), function(json) {
            if (json.code == 'success') {
                $(".error-tip").find("span").html("添加成功");
                $(".error-tip").css("background", "#5fc53d");
                $(".error-tip").show();
                window.setTimeout("window.location.reload();", 2000);
            } else {
                $(".error-tip").find("span").html(json.code);
                $(".error-tip").show();

                return false;
            }
        }, 'json');

        return false;
    });
});
</script>

<!--车辆信息开始-->
<div class="editcar" style="display:none">
    <form method="post" name="publish_vehicle_form" action="">
    <input type="hidden" name="type_id">
    <div class="loca error-tip" style="display: none;"><span></span></div>
    <div class="close"></div>
    <div class="carinfo">
        <dl>
            <dd>车牌号码</dd>
            <dt>
                <input name="vehicle_card_num" val="请输入车牌号码" value="请输入车牌号码" type="text" class="input placeholder" autocomplete="off">
                <span class="vehicle-card-num-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                <div class="item_list autocomplete-item-data" style="width: 310px;">
                </div>
            </dt>
        </dl>
        <dl>
            <dd>司机姓名</dd>
            <dt><input name="driver_name" val="请输司机姓名" value="请输司机姓名" type="text" class="input placeholder" autocomplete="off"></dt>
        </dl>
        <dl>
            <dd>联系电话</dd>
            <dt><input name="driver_mobile" type="text" val="请输入联系电话" value="请输入联系电话" class="input placeholder" autocomplete="off"></dt>
        </dl>
        <dl>
            <dd>车辆类型</dd>
            <dt><input name="vehicle_type" type="text" val="请输入车辆类型" value="请输入车辆类型" class="input placeholder" autocomplete="off"></dt>
        </dl>
        <dl>
            <dd>车辆长度</dd>
            <dt><input name="vehicle_length" type="text" val="请输入车辆长度" value="请输入车辆长度" class="input placeholder" autocomplete="off"></dt>
        </dl>
    </div>
    <div class="but_layer">
        <input type="submit" class="delcancel publish-vehicle-submit" value="确定"/>
    </div>
    </form>
</div>
<!--车辆信息结束-->