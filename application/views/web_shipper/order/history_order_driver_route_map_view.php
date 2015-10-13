<script type="text/javascript">
var truck_driver_icon = '<?php echo static_url("static/images/truck_driver_head_icon.png")?>';
var driver_head_icon_http_file = '';
var track_data_list = '';
$(function() {
    // 历史订单查看地图
    $('.history-order-show-driver-route').click(function() {
        var order_id = $("input[name=order_id]").val();

        $(".history-order-detail-driver-route-map-loading").show();

        $(".order-detail-layer").hide();

        $.post(apppath + 'order/ajax_get_track_driver_route', {order_id: order_id}, function(json) {
            if (json.code == 'success') {
                track_data_list = json.track_data_list;
                driver_head_icon_http_file = json.driver_head_icon_http_file;

                loadHistoryOrderDriverRouteJScript();

                $(".history-order-driver-route-map").show();

                $(".mask").show();
                $(".editorcontent").show();

                $(".head").addClass("fixed");
                $(".container").addClass("serachfixed");
            } else {
                alert(json.code);
                return false;
            }
        }, 'json');
    });
});

//百度地图API功能
function loadHistoryOrderDriverRouteJScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://api.map.baidu.com/api?v=2.0&ak="+baidu_ak+"&callback=init_history_order_driver_route_detail";
    document.body.appendChild(script);
}
function init_history_order_driver_route_detail() {
    var map = new BMap.Map("history_order_driver_route_detail_map");  // 创建Map实例

    // 加载完成事件
    map.addEventListener("tilesloaded",function() {
        $(".history-order-detail-driver-route-map-loading").hide();
    });

    map.addControl(new BMap.MapTypeControl());   //添加地图类型控件

    //向地图添加控件
    var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,type:0});
    map.addControl(navControl);
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

    var i = 0;
    var first_pts_var = '';
    var last_pts_var = '';
    if (track_data_list != "undefined") {
        for (; i < track_data_list.length; i++) {
            j = i + 1;

            tmp_var = "var pts"+i+" = new BMap.Point("+track_data_list[i].lng+", "+track_data_list[i].lat+");";
            eval(tmp_var);
            if (i == 0) eval("first_pts_var = pts"+i+";");
            eval("last_pts_var = pts"+i+";");

            if (typeof track_data_list[j] != "undefined") {
                var start_lng = track_data_list[i].lng;
                var start_lat = track_data_list[i].lat;
                var end_lng = track_data_list[j].lng;
                var end_lat = track_data_list[j].lat;

                if (track_data_list[i].speedInKPH <= 40) {
                    // 红色
                    var polyline = new BMap.Polyline([    
                        new BMap.Point(start_lng, start_lat),
                        new BMap.Point(end_lng, end_lat)
                     ], {strokeColor:"red", strokeWeight:6, strokeOpacity:0.5});
                    map.addOverlay(polyline);
                } else if (track_data_list[i].speedInKPH > 40 && track_data_list[i].speedInKPH <= 60)  {
                    // 黄色
                    var polyline = new BMap.Polyline([    
                        new BMap.Point(start_lng, start_lat),
                        new BMap.Point(end_lng, end_lat)
                     ], {strokeColor:"#FFD306", strokeWeight:6, strokeOpacity:0.5});
                    map.addOverlay(polyline);
                } else {
                    // 绿色
                    var polyline = new BMap.Polyline([    
                        new BMap.Point(start_lng, start_lat),
                        new BMap.Point(end_lng, end_lat)
                     ], {strokeColor:"green", strokeWeight:6, strokeOpacity:0.5});
                    map.addOverlay(polyline);
                }
            }
        };
    }

    var marker = new BMap.Marker(first_pts_var);  // 创建标注
    map.addOverlay(marker);              // 将标注添加到地图中
    var label = new BMap.Label("起点",{offset:new BMap.Size(10,-15)});
    marker.setLabel(label);

    var marker = new BMap.Marker(last_pts_var);  // 创建标注
    map.addOverlay(marker);              // 将标注添加到地图中
    var label = new BMap.Label("终点",{offset:new BMap.Size(10,-15)});
    marker.setLabel(label);

    var driver_route_icon = new BMap.Icon(truck_driver_icon, new BMap.Size(28, 28), {    //小车图片
        //offset: new BMap.Size(0, -5),    //相当于CSS精灵
        imageOffset: new BMap.Size(0, 0)    //图片的偏移量。为了是图片底部中心对准坐标点。
    });

    var carMk;
    window.run = function (){
        var i=0;
        function resetMkPoint(i){
            if (i > 0) {
                map.removeOverlay(carMk);
            }

            if (typeof track_data_list[i] != "undefined") {
                var point = new BMap.Point(track_data_list[i].lng, track_data_list[i].lat);
                carMk = new BMap.Marker(point,{icon:driver_route_icon});
                map.addOverlay(carMk);

                setTimeout(function(){
                    i++;
                    resetMkPoint(i);
                },100);
            }
        }

        setTimeout(function(){
            resetMkPoint(1);
        },100);
    };

    setTimeout(function(){
        run();
    },500);

    map.setViewport([first_pts_var, last_pts_var]); // 调整到最佳视野
}
</script>

<div class="map history-order-driver-route-map" style="display: none;">
    <div class="close"></div>
    <div class='history-order-detail-driver-route-map-loading' style="padding-top: 20px; text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>
    <div class="mapnr" style="height: 600px;" id="history_order_driver_route_detail_map">
    </div>
</div>