<script type="text/javascript">
$(function() {
    // 运单详情
    $(".show-order-detail").click(function() {
        var order_id = $(this).attr('order_id');
        $("input[name=order_id]").val(order_id);

        $(".order-detail-html").hide();
        $('.order-detail-layer-btn').show();
        $(".order-detail-loading").show();

        // 获取运单详情
        $.post(apppath + 'order/ajax_get_order_detail', {order_id: order_id}, function(json) {
            if (json.code == 'success') {
                $('.track-order-num').html('运单编号：'+json.order_detail_data.detail_order_num);

                for (var key in json.order_detail_data) {
                    $('dd[name='+key+']').html(json.order_detail_data[key]);
                }
                $('input[name=order_detail_map_lat]').val(json.order_detail_data.latitude);
                $('input[name=order_detail_map_lng]').val(json.order_detail_data.longitude);

                $(".order-detail-html").show();
                $(".order-detail-loading").hide();

                // 运单跟踪
                if (json.track_data.track_st.st_1 == 0) {
                    $('#track_st_1').show();
                } else if (json.track_data.track_st.st_1 == 1) {
                    $('#track_st_1').find('span').css('background', '');
                }

                if (json.track_data.track_st.st_3 == 0) {
                    $('#track_st_2, #track_st_3').show();
                } else if (json.track_data.track_st.st_3 == 1) {
                    $('#track_st_2, #track_st_3').find('span').css('background', '');
                }

                if (json.track_data.track_st.st_5 == 0) {
                    $('#track_st_4, #track_st_5').show();
                } else if (json.track_data.track_st.st_5 == 1) {
                    $('#track_st_4, #track_st_5').find('span').css('background', '');
                }

                var track_desc_html = '';
                for (var i = 0; i < json.track_data.track_log.length; i++) {
                    // 异常
                    var driver_anomaly = json.track_data.track_log[i].driver_anomaly;
                    if (driver_anomaly != undefined) {
                        for (var j = 0; j < driver_anomaly.length; j++) {
                            var driver_anomaly_img = driver_anomaly[j].driver_anomaly_img_list;
                            if (driver_anomaly_img != undefined) {
                                var driver_anomaly_img_html = '';
                                for (var k = 0; k < driver_anomaly_img.length; k++) {
                                    driver_anomaly_img_html += '<a href="'+driver_anomaly_img[k]+'" target="_blank"><img style="padding-bottom: 1px;" src="'+driver_anomaly_img[k]+'" width="110" height="110"></a>';
                                };
                            }

                            var driver_anomaly_text = '在 '+driver_anomaly[j].province_name+''+driver_anomaly[j].city_name+' '+driver_anomaly[j].exce_desc;

                            track_desc_html += ' \
                            <li> \
                                <span class="radius"></span> \
                                <span class="cn"> \
                                    <p>'+driver_anomaly_text+'</p> \
                                    <p> \
                                        '+driver_anomaly_img_html+' \
                                    </p> \
                                </span> \
                                <span class="data">'+driver_anomaly[j].cretime+'</span> \
                            </li>'; 
                        };
                    }

                    track_desc_html += ' \
                    <li> \
                        <span class="radius"></span> \
                        <span class="cn">'+json.track_data.track_log[i].track_desc+'</span> \
                        <span class="data">'+json.track_data.track_log[i].track_time+'</span> \
                    </li>';
                };
                $('#track_desc_html').html(track_desc_html);
            } else {
                return false;
            }
        }, 'json');

        $(".order-detail-layer").show();

        $(".mask").show();
        $(".editorcontent").show();
        
        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });

    // 查看地图
    $(".order-show-map").click(function() {
        $(".order-detail-map-loading").show();

        $(".order-detail-layer").hide();

        loadOrderDetailJScript();

        $(".order-detail-map").show();

        $(".mask").show();
        $(".editorcontent").show();

        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });

    // 运输合同
    $('.order-contract-btn').click(function() {
        var order_id = $("input[name=order_id]").val();
        window.location.href = apppath+'order/contract_order/?order_id='+order_id;
    });
});
</script>

<!--一般货主查看详情开始-->
<input type="hidden" name="order_id">
<div class="order_detail order-detail-layer" style="display: none;">
    <div class="close order-detail-close"></div>
    <?php
    if ($this->router->fetch_method() == 'history_order') {
    ?>
    <div class="lookmap order-tracking-btn" style="margin-right: 100px;">运单跟踪</div>
    <div class="lookmap history-order-show-driver-route">查看地图</div>
    <?php
    } else {
    ?>
    <div class="lookmap order-show-map">查看地图</div>
    <?php
    }
    ?>

    <div class='order-detail-loading' style="text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>
    <div class="pdinfo order-detail-html" style="display:none;">
        <h2>货物信息</h2>
        <div>
            <dl><dt>货物名称：</dt> <dd name="detail_good_name"></dd></dl>
            <dl><dt>发货人：</dt> <dd name="detail_good_mobile"></dd></dl>
            <dl><dt>货物类型：</dt> <dd name="detail_good_category"></dd></dl>
            <dl><dt>装卸要求：</dt> <dd name="detail_install_require_id"></dd></dl>
            <dl><dt>货物数量：</dt> <dd name="detail_good_nums"></dd></dl>
            <dl><dt>装货时间：</dt> <dd name="detail_good_load_time"></dd></dl>
            <dl><dt>货物重量：</dt> <dd name="detail_good_load"></dd></dl>
            <dl><dt>装货地点：</dt> <dd name="detail_good_load_addr"></dd></dl>
            <dl><dt>货物体积：</dt> <dd name="detail_good_volume"></dd></dl>
            <dl><dt>发车时间：</dt> <dd name="detail_good_start_time"></dd></dl>
            <dl><dt>出发地：</dt> <dd name="detail_start_location"></dd></dl>
            <dl><dt>收货人：</dt> <dd name="detail_good_contact"></dd></dl>
            <dl><dt>目的地：</dt> <dd name="detail_end_location"></dd></dl>
            <dl><dt>卸货时间：</dt> <dd name="detail_good_unload_time"></dd></dl>
            <dl><dt>运送价格：</dt> <dd name="detail_good_freight"></dd></dl>
            <dl><dt>卸货地点：</dt> <dd name="detail_good_unload_addr"></dd></dl>
            <dl><dt>保证金：</dt> <dd name="detail_good_margin"></dd></dl>
            <dl><dt>运单编号：</dt> <dd name="detail_order_num"></dd></dl>
        </div>
    </div>
    <br><br>
    <div class="pdinfo order-detail-html" style="display:none;">
        <h2>承接司机信息</h2>
        <div>
            <dl><dt>司机姓名：</dt> <dd name="detail_driver_name"></dd></dl>
            <dl><dt>联系方式：</dt> <dd name="detail_driver_mobile"></dd></dl>
            <dl><dt>当前位置：</dt> <dd name="detail_current_location"></dd></dl>
            <dl><dt>车牌号：</dt> <dd name="detail_vehicle_card_num"></dd></dl>
            <dl><dt>货车类型：</dt> <dd name="detail_vehicle_type"></dd></dl>
            <dl><dt>车辆长度：</dt> <dd name="detail_vehicle_length"></dd></dl>
        </div>
    </div>
</div>
<!--一般货主查看详情结束-->

<?php $this->load->view($this->appfolder.'/order/track_order_view')?>

<script type="text/javascript">
//百度地图API功能
function loadOrderDetailJScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://api.map.baidu.com/api?v=2.0&ak="+baidu_ak+"&callback=init_order_detail";
    document.body.appendChild(script);
}
function init_order_detail() {
    var lat = $('input[name=order_detail_map_lat]').val();
    var lng = $('input[name=order_detail_map_lng]').val();
    var driver_name = $('dd[name=detail_driver_name]').html();
    var driver_mobile = $('dd[name=detail_driver_mobile]').html();

    var map = new BMap.Map("order_detail_map");  // 创建Map实例
    map.centerAndZoom(new BMap.Point(lng, lat), 15);  // 初始化地图,设置中心点坐标和地图级别

    // 加载完成事件
    map.addEventListener("tilesloaded",function() {
        $(".order-detail-map-loading").hide();
    });

    map.addControl(new BMap.MapTypeControl());   //添加地图类型控件

    //向地图添加控件
    var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,type:0});
    map.addControl(navControl);

    // 添加标注
    var point = new BMap.Point(lng, lat);
    var marker = new BMap.Marker(point);
    map.addOverlay(marker);

    // 标注文字
    var label_text = driver_name+"<br />"+driver_mobile;
    var label = new BMap.Label(label_text,{offset:new BMap.Size(13,-50)});
    marker.setLabel(label);
    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
}
</script>

<!-- 运单详情查看地图开始 -->
<input type='hidden' name="order_detail_map_lat">
<input type='hidden' name="order_detail_map_lng">
<div class="map order-detail-map" style="display: none;">
    <div class="close"></div>
    <div class='order-detail-map-loading' style="padding-top: 20px; text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>
    <div class="mapnr" style="height: 600px;" id="order_detail_map">
    </div>
</div>
<!-- 运单详情查看地图结束 -->