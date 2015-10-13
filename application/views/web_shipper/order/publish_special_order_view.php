<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<!-- jquery ui -->
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui-timepicker-addon.css')?>">
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.ui.datepicker-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui-timepicker-addon.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui-timepicker-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/address_autocomplete.js')?>"></script>

<style type="text/css">
.container .success {
    height: 80px;
    width: 960px;
    margin: 0 auto;
}
.container .success span{
    width: 300px;
    height: 50px;
    border-radius: 5px;
    background: #5fc53d;
    margin-top: 20px;
    margin-bottom: 10px;
    display: block;
    margin: 0 auto;
    color: #fff;
    text-align: center;
    font-size: 18px;
    line-height: 50px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(153,153,153,0.6);
}
</style>

<script type="text/javascript">
$(function() {
    window.placeholder();

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
    $("select[name=route_id]").trigger('change');

    $(".publish-special-order-submit").click(function() {
        var btn_obj = $(this);
        btn_obj.attr('disabled', true);

        $(".error").hide();
        $(".success").hide();

        var order_type = $(this).attr("order_type");
        $("input[name=order_type]").val(order_type);

        $.post(apppath + fetch_class + '/ajax_do_special_order', $("form[name=publish_special_order_form]").serialize(), function(json) {
            if (json.code == 'success') {
                $(".success").show();
                window.setTimeout("window.location.reload();", 1000);
            } else {
                btn_obj.attr('disabled', false);
                
                $(".error").find("span").html(json.code);
                $(".error").show();

                return false;
            }
        }, 'json');

        return false;
    });

    // function getNowFormatDate() {
    //     var date = new Date();
    //     var seperator1 = "-";
    //     var seperator2 = ":";
    //     var month = date.getMonth() + 1;
    //     var strDate = date.getDate();
    //     if (month >= 1 && month <= 9) {
    //         month = "0" + month;
    //     }
    //     if (strDate >= 0 && strDate <= 9) {
    //         strDate = "0" + strDate;
    //     }
    //     var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
    //             + " " + date.getHours() + seperator2 + date.getMinutes()
    //             + seperator2 + date.getSeconds();
    //     return currentdate;
    // }

    // // 定时提交 默认一分钟
    // window.setTimeout(function() {
    //     $(".success").hide();
    //     if ($('input[name=good_name]').val() != '请输入货物名称') {
    //         $(".success").find("span").html('已保存草稿箱');
    //         $(".success").show();
    //         var cur_date = getNowFormatDate();
    //         $('.publish-special-order-submit[order_type=1]').trigger('click');
    //     }
    // }, 60000);
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="container">
    <div class="error" style="display: none;"><span>操作失败</span></div>
    <div class="success" style="display: none;"><span>操作成功</span></div>
    <form name="publish_special_order_form" action="" method="post">
    <input type="hidden" name="order_type">
    <input type="hidden" name="start_city_id">
    <input type="hidden" name="end_city_id">
    <div class="neworder">
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
                <input type="hidden" name="good_load_addr_lat_lng" value="">
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
            <dd>
                <input type="hidden" name="good_unload_addr_lat_lng" value="">
                <input name="good_unload_addr" type="text" class="input placeholder" val="请输入卸货地点" value="请输入卸货地点" autocomplete="off"/>
                <span class="good-unload-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                <div class="item_list good-unload-addr-address-list">
                </div>
            </dd>
        </dl>
    </div>
    </form>
    <div class="operation">
        <input type="submit" class="cancel publish-special-order-submit" value="确定送出" order_type="2">
        <input type="button" class="cancel publish-special-order-submit" value="保存草稿" order_type="1">
        <input type="button" class="cancel" value="删除重填" onclick="javascript: window.location.reload();">
    </div>
</div>

</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>