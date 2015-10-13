<!-- jquery ui -->
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui-timepicker-addon.css')?>">
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.ui.datepicker-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui-timepicker-addon.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui-timepicker-zh-CN.js')?>"></script>

<script type="text/javascript">
$(function() {
    // 显示指派运单层
    $("a[name=assign_order]").click(function() {
        var vehicle_id = $(this).attr("vehicle_id");
        $("select[name=vehicle_id]").val(vehicle_id);

        $(".orderedit").show();

        $(".mask").show();
        $(".editorcontent").show();

        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });

    $("input[name=good_load_time]").mousedown(function() {
        $(this).datetimepicker();
    });
    $("input[name=good_start_time]").mousedown(function() {
        $(this).datetimepicker();
    });
    $("input[name=good_unload_time]").mousedown(function() {
        $(this).datetimepicker();
    });

    // 指派运单提交
    $(".publish-special-order-submit").click(function() {
        $(".error-tip").css("background", "#f26b54").hide();

        var order_type = $(this).attr("order_type");
        $("input[name=order_type]").val(order_type);

        $.post(apppath + 'order/ajax_do_special_order', $("form[name=publish_special_order_form]").serialize(), function(json) {
            if (json.code == 'success') {
                $(".error-tip").find("span").html("指派运单成功");
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

<!--新建运单开始-->
<form name="publish_special_order_form" action="" method="post">
<input type="hidden" name="order_type">
<div class="orderedit" style="display:none;">
    <div class="loca error-tip" style="display: none;"><span></span></div>
    <div class="close"></div>
    <div class="editnr">    
        <dl>
            <dt>货物名称</dt>
            <dd><input name="good_name" type="text" class="input placeholder" val="请输入货物名称" value="请输入货物名称"/></dd>
        </dl>
        <dl>
            <dt>装货时间</dt>
            <dd>
                <input name="good_load_time" type="text" class="input placeholder" val="请选择装货时间" value="请选择装货时间" readonly="readonly" />
             </dd>
        </dl>
        <dl>
            <dt>货运路线</dt>
            <dd>
                <select class="singular-select" name="route_id">
                    <?php echo $get_shipper_route_options?>
                </select>
             </dd>
        </dl>
        <dl>
            <dt>装货地点</dt>
            <dd>
                <input name="good_load_addr" type="text" class="input placeholder" val="请输入装货地点" value="请输入装货地点" autocomplete="off"/>
            </dd>
        </dl>
        <dl>
            <dt>发货人</dt>
            <dd>
                <input name="good_mobile" type="text" class="input placeholder" val="请输入发货人" value="请输入发货人"/></dd>
        </dl>
        <dl>
            <dt>发车时间</dt>
            <dd>
                <input name="good_start_time" type="text" class="input placeholder" val="请选择发车时间" value="请选择发车时间" readonly="readonly"/>
            </dd>
        </dl>
        <dl>
            <dt>收货人</dt>
            <dd><input name="good_contact" type="text" class="input placeholder" val="请输入收货人" value="请输入收货人"/></dd>
        </dl>
        <dl>
            <dt>卸货时间</dt>
            <dd>
                <input name="good_unload_time" type="text" class="input placeholder" val="请选择卸货时间" value="请选择卸货时间" readonly="readonly"/>
            </dd>
        </dl>
        <dl>
            <dt>指定货车</dt>
            <dd>
                <select class="singular-select" name="vehicle_id">
                    <?php echo $get_current_shipper_driver_vehicle_options?>
                </select>
            </dd>
        </dl>
        <dl>
            <dt>卸货地点</dt>
            <dd><input name="good_unload_addr" type="text" class="input placeholder" val="请输入卸货地点" value="请输入卸货地点" autocomplete="off"/></dd>
        </dl>
    </div>
    <div class="operation">
        <input type="submit" class="save publish-special-order-submit" value="保存" order_type="2">
        <input type="button" class="cancel" value="取消">
    </div>
</div>
</form>
<!--新建运单结束-->