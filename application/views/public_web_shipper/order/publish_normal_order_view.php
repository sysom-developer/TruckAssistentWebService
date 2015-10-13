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

    // 出发地
    $("select[name=start_province_id]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=start_city_id]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + fetch_class + '/ajax_get_region', {id: id}, function(json) {
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

        $.post(apppath + fetch_class + '/ajax_get_region', {id: id}, function(json) {
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

    $(".publish-normal-order-submit").click(function() {
        var btn_obj = $(this);
        btn_obj.attr('disabled', true);

        $(".error").hide();
        $(".success").hide();

        var order_type = $(this).attr("order_type");
        $("input[name=order_type]").val(order_type);

        $.post(apppath + fetch_class + '/ajax_do_normal_order', $("form[name=publish_normal_order_form]").serialize(), function(json) {
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
    //         $('.publish-normal-order-submit[order_type=1]').trigger('click');
    //     }
    // }, 60000);
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="container">
    <div class="error" style="display: none;"><span>操作失败</span></div>
    <div class="success" style="display: none;"><span>操作成功</span></div>
    <form name="publish_normal_order_form" action="" method="post">
    <input type="hidden" name="order_type">
    <div class="neworder">
        <dl>
            <dt>货物名称</dt>
            <dd><input name="good_name" type="text" class="input placeholder" val="请输入货物名称" value="请输入货物名称"/></dd>
        </dl>
        <dl>
            <dt>指定货车</dt>
            <dd>
                 <select name="vehicle_id" class="singular-select">
                     <?php echo $get_current_shipper_driver_vehicle_options?>
                 </select>
            </dd>
        </dl>
        <dl>
            <dt>货物类型</dt>
            <dd>
                 <select class="singular-select" name="good_category">
                     <?php echo $get_goods_category_options?>
                 </select>
             </dd>
        </dl>
        <dl>
            <dt>发货人</dt>
            <dd>
                <input name="good_mobile" type="text" class="input placeholder" val="请输入发货人电话" value="请输入发货人电话"/></dd>
        </dl>
        <dl>
            <dt>货物数量</dt>
            <dd><input name="good_nums" type="text" class="input placeholder" val="请输入货物数量" value="请输入货物数量"/></dd>
        </dl>
        <dl>
            <dt>收货人</dt>
            <dd><input name="good_contact" type="text" class="input placeholder" val="请输入收货人电话" value="请输入收货人电话"/></dd>
        </dl>
        <dl>
            <dt>货物重量</dt>
            <dd><input name="good_load" type="text" class="input placeholder" val="请输入货物重量" value="请输入货物重量"/></dd>
        </dl>
        <dl>
            <dt>装卸要求</dt>
            <dd>
                 <select class="singular-select" name="install_require_id">
                     <?php
                     if ($install_require) {
                        foreach ($install_require as $value) {
                    ?>
                    <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                    <?php
                         }
                     }
                     ?>
                 </select>
            </dd>
        </dl>
        <dl>
            <dt>货物体积</dt>
            <dd><input name="good_volume" type="text" class="input placeholder" val="请输入货物体积" value="请输入货物体积"/></dd>
        </dl>
        <dl>
            <dt>装货时间</dt>
            <dd>
                 <input name="good_load_time" type="text" class="input placeholder" val="请选择装货时间" value="请选择装货时间"/>
            </dd>
        </dl>
        <dl>
            <dt>货物超限</dt>
            <dd>
                 <select class="singular-select" name="is_overranging_id">
                     <?php
                     if ($is_overranging) {
                        foreach ($is_overranging as $value) {
                    ?>
                    <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                    <?php
                         }
                     }
                     ?>
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
            <dt>运送价格</dt>
            <dd><input name="good_freight" type="text" class="input placeholder" val="请输入运送价格" value="请输入运送价格"/></dd>
        </dl>
        <dl>
            <dt>发车时间</dt>
            <dd>
                <input name="good_start_time" type="text" class="input placeholder" val="请选择发车时间" value="请选择发车时间"/>
            </dd>
        </dl>
        <dl>
            <dt>保证金</dt>
            <dd><input name="good_margin" type="text" class="input placeholder" val="请输入保证金额度" value="请输入保证金额度"/></dd>
        </dl>
        <dl>
            <dt>卸货时间</dt>
            <dd>
                <input name="good_unload_time" type="text" class="input placeholder" val="请选择卸货时间" value="请选择卸货时间"/>
            </dd>
        </dl>
        <dl>
            <dt>出发地</dt>
            <dd>
                <select name="start_province_id" class="dual-select">
                    <option value="0">请选择省</option>
                    <?php echo $get_region_options?>
                </select>
                <select name="start_city_id" class="dual-select">
                    <option value="0">请选择市</option>
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
        <dl>
            <dt>目的地</dt>
            <dd>
                <select name="end_province_id" class="dual-select">
                    <option value="0">请选择省</option>
                    <?php echo $get_region_options?>
                </select>
                <select name="end_city_id" class="dual-select">
                    <option value="0">请选择市</option>
                </select>
            </dd>
        </dl>
    </div>
    </form>
    <div class="operation">
        <input type="submit" class="cancel publish-normal-order-submit" value="确定送出" order_type="2">
        <input type="button" class="cancel publish-normal-order-submit" value="保存草稿" order_type="1">
        <input type="button" class="cancel" value="删除重填" onclick="javascript: window.location.reload();">
    </div>
</div>

</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>