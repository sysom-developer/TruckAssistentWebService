<!-- jquery ui -->
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui-timepicker-addon.css')?>">
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.ui.datepicker-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui-timepicker-addon.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui-timepicker-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/address_autocomplete.js')?>"></script>

<script type="text/javascript">
$(function() {
    $('.order-edit').click(function() {
        var order_id = $(this).attr('order_id');

        $(".order-edit-html").hide();
        $('.order-edit-layer-btn').show();
        $(".order-edit-loading").show();

        // 获取运单详情
        $.post(apppath + 'order/ajax_get_order_detail', {order_id: order_id}, function(json) {
            if (json.code == 'success') {
                $('input[name=order_id]').val(order_id);
                $('input[name=good_name]').val(json.order_detail_data['detail_good_name']);
                $('input[name=good_load_time]').val(json.order_detail_data['detail_good_load_time']);
                $('input[name=good_load_addr]').val(json.order_detail_data['detail_good_load_addr']);
                $('input[name=good_mobile]').val(json.order_detail_data['detail_good_mobile']);
                $('input[name=good_start_time]').val(json.order_detail_data['detail_good_start_time']);
                $('input[name=good_contact]').val(json.order_detail_data['detail_good_contact']);
                $('input[name=good_unload_time]').val(json.order_detail_data['detail_good_unload_time']);
                $('input[name=good_unload_addr]').val(json.order_detail_data['detail_good_unload_addr']);

                $('input[name=start_city_id]').val(json.order_detail_data['start_city_id']);
                $('input[name=end_city_id]').val(json.order_detail_data['end_city_id']);
                $('select[name=vehicle_id] [value='+json.order_detail_data['vehicle_id']+']').attr('selected', true);
                $('select[name=route_id] option').each(function () {
                    if ($(this).html() == json.order_detail_data['route_id']) {
                        $(this).attr('selected', true);
                    }
                });

                $(".order-edit-html").show();
                $(".order-edit-loading").hide();
            } else {
                return false;
            }
        }, 'json');

        $('.order-edit-layer').show();

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

    // 选择线路
    $("select[name=route_id]").change(function() {
        var route_id = $(this).val();

        $.post(apppath + '/order/ajax_get_route_data', {route_id: route_id}, function(json) {
            $(".error").hide();
            if (json.code == 'success') {
                $("input[name=start_city_id]").val(json.start_city_id);
                $("input[name=end_city_id]").val(json.end_city_id);
            }
        }, 'json');

        return false;
    });

    $(".edit-draft-order-submit").click(function() {
        $(".errormessage").hide();

        var order_type = $(this).attr("order_type");
        $("input[name=order_type]").val(order_type);

        $.post(apppath + 'order/ajax_edit_special_order', $("form[name=edit_special_order_form]").serialize(), function(json) {
            if (json.code == 'success') {
                $(".errormessage").find("span").html('操作成功');
                $(".errormessage").css("background", "#5fc53d");
                $(".errormessage").show();
                window.setTimeout("window.location.reload();", 2000);
            } else {
                $(".errormessage").find("span").html(json.code);
                $(".errormessage").show();

                return false;
            }
        }, 'json');

        return false;
    });
});
</script>

<form name="edit_special_order_form" action="" method="post">
<input type="hidden" name="order_id">
<input type="hidden" name="order_type">
<input type="hidden" name="start_city_id">
<input type="hidden" name="end_city_id">
<div class="neworder order-edit-layer" style="display: none;">
    <div class="errormessage" style="display: none;"><span>操作失败</span></div>
    <div class="close order-edit-close"></div>

    <div class='order-edit-loading' style="text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>

    <div class="order-edit-html" style="display: none;">
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
                <span class="good-load-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                <div class="item_list autocomplete-item-data">
                </div>
            </dd>
        </dl>
        <dl>
            <dt>发货人</dt>
            <dd>
                <input name="good_mobile" type="text" class="input placeholder" val="请输入发货人" value="请输入发货人"/>
            </dd>
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
            <dt>缺货时间</dt>
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
            <dd>
                <input name="good_unload_addr" type="text" class="input placeholder" val="请输入卸货地点" value="请输入卸货地点" autocomplete="off"/>
                <span class="good-unload-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                <div class="item_list good-unload-addr-address-list">
                </div>
            </dd>
        </dl>
    </div>
</div>
<div class="savebut order-edit-layer-btn" style="display: none;">
    <input type="submit" class="cancel edit-draft-order-submit" value="确定送出" order_type="2">
    <input type="button" class="cancel edit-draft-order-submit" value="保存草稿" order_type="1">
    <input type="reset" class="cancel" value="清除重填">
</div>
</form>