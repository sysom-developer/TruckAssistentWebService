<div id"all_vehicle_map" class="all_vehicle_map">
    <div class='all-vehicle-map-loading' style="padding-top: 20px; text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>
    <div style="width:100%;height:580px;border:#ccc solid 1px;" id="map_all_vehicle_div"></div>
	<?php
    if ($this->router->fetch_method() == 'vehicle_list') {
    ?>
    <div class="map_tagging all-vehicle-map-tip" style="display: none;">
        <p><img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_red_vehicle_2.png')?>"/>在途车辆</p>
        <p><img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_green_vehicle_2.png')?>"/>可用车辆</p>
        <p><img src="<?php echo static_url('static/images/'.$this->appfolder.'/driver_anomaly_icon_title.png')?>"/>异常车辆</p>
    </div>
    <?php
    }
    ?>
</div>
<script type="text/javascript">
function show_alone_vehicle_map(order_id) {
    window.location.href = apppath+'vehicle/?order_type=4&order_id='+order_id;
}
function loadAllVehicleMapJScript() {
    $(".all-vehicle-map-loading").show();

    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://api.map.baidu.com/api?v=2.0&ak="+baidu_ak+"&callback=init_all_vehicle_map";
    document.body.appendChild(script);
}
function init_all_vehicle_map() {
    var map = new BMap.Map("map_all_vehicle_div");  // 创建Map实例
    
    // 加载完成事件
    map.addEventListener("tilesloaded",function() {
        $(".all-vehicle-map-loading").hide();
        $('.all-vehicle-map-tip').show();
    });

    var k = '<?php echo $k?>';
    if (k == '') {
        window.setTimeout(function(){
            map.centerAndZoom("<?php echo $company_city?>", 11);
        }, 300);  // 延迟放大
    } else {
        window.setTimeout(function(){
            map.centerAndZoom("武汉", 6);
        }, 300);  // 延迟放大
    }

    //向地图添加控件
    var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,type:0});
    map.addControl(navControl);
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

    var js_lat_lng = <?php echo $js_lat_lng?>;
    for (var i = js_lat_lng.length - 1; i >= 0; i--) {
        // 距离
        var pointA = new BMap.Point(js_lat_lng[i].start_lng,js_lat_lng[i].start_lat);
        var pointB = new BMap.Point(js_lat_lng[i].end_lng,js_lat_lng[i].end_lat);
        // 转换公里
        distance_meter = map.getDistance(pointA,pointB).toFixed(2);
        distance_km = '';
        if (distance_meter > 0) {
            km = distance_meter / 1000;
            distance_km = km.toFixed(1)+'公里';
        }

        var order_type_desc = '';
        var markerIconUrl = map_green_vehicle_url;
        if (js_lat_lng[i].order_type == 4) {
            order_type_desc = "<br />订单状态：" + js_lat_lng[i].order_type_desc + "<br />剩余里程：" + distance_km;
            markerIconUrl = map_red_vehicle_url;
        }

        // 是否异常
        if (js_lat_lng[i].is_anomaly > 0) {
            markerIconUrl = map_red_anomaly_icon_url;
        }

        // 自定义点的图片
        var markerIcon = new BMap.Icon(markerIconUrl, new BMap.Size(35,58));

        var opts = {
            width : 200,     // 信息窗口宽度
            height: 150,     // 信息窗口高度
            title : "" , // 信息窗口标题
            enableMessage:true//设置允许信息窗发送短息
        };

        // 创建标注
        var point = new BMap.Point(js_lat_lng[i].lng, js_lat_lng[i].lat);
        var marker = new BMap.Marker(point,{icon:markerIcon});

        var content = js_lat_lng[i].driver_name + "<br />" + js_lat_lng[i].driver_mobile + "<br /><br />当前位置：" + js_lat_lng[i].current_location + order_type_desc + "<br />已停留时间：" + js_lat_lng[i].stay_time;

        // 显示司机姓名
        var label = new BMap.Label(js_lat_lng[i].driver_name,{offset:new BMap.Size(20,-18)});
        marker.setLabel(label);

        if (js_lat_lng[i].order_type == 4) {
            var content = js_lat_lng[i].driver_name + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + "<input type='button' onclick='javascript:show_alone_vehicle_map("+js_lat_lng[i].order_id+");' value='查看轨迹'>" + "<br />" + js_lat_lng[i].driver_mobile + "<br /><br />" + js_lat_lng[i].order_start_city + ' 至 ' + js_lat_lng[i].order_end_city + "<br />当前位置：" + js_lat_lng[i].current_location + order_type_desc + "<br />预计到达时间：" + js_lat_lng[i].good_end_time + "<br />";

            addClickHandler(js_lat_lng[i].order_id, marker);
            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        }

        // 是否异常，异常内容
        if (js_lat_lng[i].is_anomaly > 0) {
            var content = js_lat_lng[i].driver_name + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + "<br />" + js_lat_lng[i].driver_mobile + "<br /><br />异常情况：" + js_lat_lng[i].anomaly_desc + "";
        }

        // 添加标注
        map.addOverlay(marker);
        addMouseHandler(content,marker);
    };

    function addClickHandler(order_id){
        marker.addEventListener("click",function(){
            window.location.href = apppath+'vehicle/?order_type=4&order_id='+order_id;
        });
    }

    function addMouseHandler(content,marker){
        marker.addEventListener("mouseover",function(e){
            openInfo(content,e)}
        );

        // marker.addEventListener("mouseout",function(e){
        //     closeInfo(content,e)}
        // );
    }
    function openInfo(content,e){
        var p = e.target;
        var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
        var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
        map.openInfoWindow(infoWindow,point); //开启信息窗口
    }
    function closeInfo(content,e){
        var p = e.target;
        var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
        var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
        map.closeInfoWindow(infoWindow,point); //开启信息窗口
    }
}

loadAllVehicleMapJScript();
</script>