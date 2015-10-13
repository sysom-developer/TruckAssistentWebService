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
var id = '<?php echo $id?>';
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

    // 出发地
    $("select[name=start_province_id]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=start_city_id]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + 'order/ajax_get_region', {id: id}, function(json) {
            if (json.code == 'success') {
                var option = '<option value="0">请选择市</option>';
                for (var i=0; i<json.data.length; i++) {
                    option += '<option value="'+json.data[i].id+'">'+json.data[i].region_name+'</option>';
                }

                $("select[name=start_city_id]").html(option);
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });

    // 目的地
    $("select[name=end_province_id]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=end_city_id]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + 'order/ajax_get_region', {id: id}, function(json) {
            if (json.code == 'success') {
                var option = '<option value="0">请选择市</option>';
                for (var i=0; i<json.data.length; i++) {
                    option += '<option value="'+json.data[i].id+'">'+json.data[i].region_name+'</option>';
                }

                $("select[name=end_city_id]").html(option);
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });

    $(".edit-order-submit").click(function() {
        var btn_obj = $(this);
        btn_obj.attr('disabled', true);

        $.post(apppath + 'order/ajax_edit_do_normal_order', $("form[name=edit_order_form]").serialize(), function(json) {
            if (json.code == 'success') {
                alert('操作成功');
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

        $.post(apppath + 'order/ajax_edit_change_data', {company_id, company_id}, function(json) {
            if (json.code == 'success') {
                $('select[name=shipper_id]').html(json.shipper_option);
                $('select[name=vehicle_id]').html(json.shipper_driver_option);
            } else {
                alert(json.code);
                return false;
            }
        }, 'json');

        return false;
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
    <form name="edit_order_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id?>">
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
                <td>货物名称：</td>
                <td>
                    <input type="text" class="txt" name="good_name" value="<?php echo $order_data['good_name']?>">
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
                <td>货物类型：</td>
                <td>
                    <select name="good_category" style="width: auto;">
                        <?php echo $goods_category_option?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>装卸要求：</td>
                <td>
                    <select name="install_require_id" style="width: auto;">
                    <?php
                    if ($install_require) {
                        foreach ($install_require as $value) {
                    ?>
                    <option value="<?php echo $value['id']?>" <?php if ($value['id'] == $order_data['install_require_id']) { echo 'selected';}?>><?php echo $value['name']?></option>
                    <?php
                        }
                    }
                    ?>
                 </select>
                </td>
            </tr>
            <tr>
                <td>货物超限：</td>
                <td>
                    <select name="is_overranging_id">
                    <?php
                    if ($is_overranging) {
                        foreach ($is_overranging as $value) {
                    ?>
                    <option value="<?php echo $value['id']?>" <?php if ($value['id'] == $order_data['is_overranging_id']) { echo 'selected';}?>><?php echo $value['name']?></option>
                    <?php
                        }
                    }
                    ?>
                 </select>
                </td>
            </tr>
            <tr>
                <td>货物数量：</td>
                <td>
                    <input name="good_nums" type="text" class="txt" value="<?php echo $order_data['good_nums']?>"/>
                </td>
            </tr>
            <tr>
                <td>货物重量：</td>
                <td>
                    <input name="good_load" type="text" class="txt" value="<?php echo $order_data['good_load']?>"/>
                </td>
            </tr>
            <tr>
                <td>货物体积：</td>
                <td>
                    <input name="good_volume" type="text" class="txt" value="<?php echo $order_data['good_volume']?>"/>
                </td>
            </tr>
            <tr>
                <td>发货人：</td>
                <td>
                    <input name="good_mobile" type="text" class="txt" value="<?php echo $order_data['good_mobile']?>"/>
                </td>
            </tr>
            <tr>
                <td>出发地：</td>
                <td>
                    <select name="start_province_id" style="width: auto;">
                        <option value="0">请选择省</option>
                        <?php echo $start_region_options?>
                    </select>
                    <select name="start_city_id" style="width: auto;">
                        <?php echo $start_city_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>装货地点：</td>
                <td>
                    <input type="hidden" name="good_load_addr_lat_lng" value='<?php echo json_encode(array('lat' => $order_data['start_location_lat'], 'lng' => $order_data['start_location_lng']))?>'>
                    <input name="good_load_addr" type="text" class="txt" value="<?php echo $order_data['good_load_addr']?>" autocomplete="off"/>
                    <span class="good-load-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                    <div class="item_list autocomplete-item-data">
                    </div>
                </td>
            </tr>
            <tr>
                <td>装货时间：</td>
                <td>
                    <input name="good_load_time" type="text" class="txt" value="<?php echo date('Y-m-d H:i', $order_data['good_load_time'])?>" readonly="readonly"/>
                </td>
            </tr>
            <tr>
                <td>收货人：</td>
                <td>
                    <input name="good_contact" type="text" class="txt" value="<?php echo $order_data['good_contact']?>"/>
                </td>
            </tr>
            <tr>
                <td>发车时间：</td>
                <td>
                    <input name="good_start_time" type="text" class="txt" value="<?php echo date('Y-m-d H:i', $order_data['good_start_time'])?>" readonly="readonly"/>
                </td>
            </tr>
            <tr>
                <td>目的地：</td>
                <td>
                    <select name="end_province_id" style="width: auto;">
                        <option value="0">请选择省</option>
                        <?php echo $end_region_options?>
                    </select>
                    <select name="end_city_id" style="width: auto;">
                        <?php echo $end_city_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>卸货地点：</td>
                <td>
                    <input type="hidden" name="good_unload_addr_lat_lng" value='<?php echo json_encode(array('lat' => $order_data['end_location_lat'], 'lng' => $order_data['end_location_lng']))?>'>
                    <input name="good_unload_addr" type="text" class="txt" value="<?php echo $order_data['good_unload_addr']?>" autocomplete="off"/>
                    <span class="good-unload-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                    <div class="item_list good-unload-addr-address-list">
                    </div>
                </td>
            </tr>
            <tr>
                <td>卸货时间：</td>
                <td>
                    <input name="good_unload_time" type="text" class="txt" value="<?php echo date('Y-m-d H:i', $order_data['good_unload_time'])?>" readonly="readonly" />
                </td>
            </tr>
            <tr>
                <td>运送价格：</td>
                <td>
                    <input name="good_freight" type="text" class="txt" value="<?php echo $order_data['good_freight']?>"/>
                </td>
            </tr>
            <tr>
                <td>保证金：</td>
                <td>
                    <input name="good_margin" type="text" class="txt" value="<?php echo $order_data['good_margin']?>"/>
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td>
                    <select name="order_type" style="width: auto;">
                        <?php
                        foreach ($order_type_desc as $config_order_type => $config_order_type_desc) {
                        ?>
                        <option value="<?php echo $config_order_type?>" <?php if ($config_order_type == $order_data['order_type']) { echo 'selected';}?>><?php echo $config_order_type_desc?></option>
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
                        <option value="1" <?php if ($order_data['order_status'] == 1) { echo 'selected';}?>>有效</option>
                        <option value="2" <?php if ($order_data['order_status'] == 2) { echo 'selected';}?>>无效</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" class="btn edit-order-submit" value="确 认" />
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