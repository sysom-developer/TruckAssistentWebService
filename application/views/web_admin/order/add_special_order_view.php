<?php $this->load->view(''.$this->appfolder.'/header_view');?>

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

    $(".add-order-submit").click(function() {
        var btn_obj = $(this);
        btn_obj.attr('disabled', true);

        $.post(apppath + 'order/ajax_do_special_order', $("form[name=publish_order_form]").serialize(), function(json) {
            if (json.code == 'success') {
                alert('添加成功');
                window.location.href = apppath+'/order';
            } else {
                btn_obj.attr('disabled', false);
                
                alert(json.code);
                return false;
            }
        }, 'json');

        return false;
    });

    $('select[name=company_id]').change(function() {
        var company_id = $(this).val();

        window.location.href = apppath+'order/add_data?company_id='+company_id;
    });
});
</script>

<body>
<div class="warrper">
<div class="content">

    <?php $this->load->view(''.$this->appfolder.'/path_view');?>
    
    <div class="shop">
        <div class="shop_content">
            <div class="search_box">
                <p><strong><?php echo $path_name?></strong></p>
            </div>
        </div>
    </div>
    <form name="publish_order_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="order_type">
    <input type="hidden" name="start_city_id">
    <input type="hidden" name="end_city_id">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="130">所属货运公司：</td>
                <td>
                    <select name="company_id" style="width: auto;">
                        <?php echo $shipper_company_option?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>所属货主：</td>
                <td>
                    <select name="shipper_id" style="width: auto;">
                        <?php echo $shipper_option?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>货运线路：</td>
                <td>
                    <select name="route_id" style="width: auto;">
                        <?php echo $shipper_route_option?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>货物名称：</td>
                <td>
                    <input type="text" class="txt" name="good_name" value="">
                </td>
            </tr>
            <tr>
                <td>指定货车：</td>
                <td>
                    <select name="vehicle_id" style="width: auto;">
                        <?php echo $shipper_driver_option?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>发货人：</td>
                <td>
                    <input name="good_mobile" type="text" class="txt" value=""/>
                </td>
            </tr>
            <tr>
                <td>装货地点：</td>
                <td>
                    <input type="hidden" name="good_load_addr_lat_lng" value="">
                    <input name="good_load_addr" type="text" class="txt" value="" autocomplete="off"/>
                    <span class="good-load-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                    <div class="item_list autocomplete-item-data">
                    </div>
                </td>
            </tr>
            <tr>
                <td>装货时间：</td>
                <td>
                    <input name="good_load_time" type="text" class="txt" value="" readonly="readonly"/>
                </td>
            </tr>
            <tr>
                <td>发车时间：</td>
                <td>
                    <input name="good_start_time" type="text" class="txt" value="" readonly="readonly"/>
                </td>
            </tr>
            <tr>
                <td>收货人：</td>
                <td>
                    <input name="good_contact" type="text" class="txt" value=""/>
                </td>
            </tr>
            <tr>
                <td>卸货地点：</td>
                <td>
                    <input type="hidden" name="good_unload_addr_lat_lng" value="">
                    <input name="good_unload_addr" type="text" class="txt" value="" autocomplete="off"/>
                    <span class="good-unload-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                    <div class="item_list good-unload-addr-address-list">
                    </div>
                </td>
            </tr>
            <tr>
                <td>卸货时间：</td>
                <td>
                    <input name="good_unload_time" type="text" class="txt" value="" readonly="readonly" />
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td>
                    <select name="order_type" style="width: auto;">
                        <?php
                        foreach ($order_type_desc as $config_order_type => $config_order_type_desc) {
                        ?>
                        <option value="<?php echo $config_order_type?>"><?php echo $config_order_type_desc?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>是否有效：</td>
                <td>
                    <select name="order_status" style="width: auto;">
                        <option value="1" selected>有效</option>
                        <option value="2">无效</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" class="btn add-order-submit" value="确 认" />
                    <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回" />
                </td>
            </tr>
        </table>
    </div>
    </form>
</div>
</div>
</body>
</html>