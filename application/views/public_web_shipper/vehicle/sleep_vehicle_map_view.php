<div id"all_vehicle_map" class="all_vehicle_map">
    <div class='all-vehicle-map-loading' style="padding-top: 20px; text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>
    <div style="width:100%;height:580px;border:#ccc solid 1px;" id="map_all_vehicle_div"></div>
</div>

<script type="text/javascript">
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

        var order_type_desc = '';
        var markerIconUrl = map_green_vehicle_url;
        order_type_desc = "<br />订单状态：" + js_lat_lng[i].order_type_desc;

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

        var content = js_lat_lng[i].driver_name + "<br />" + js_lat_lng[i].driver_mobile + "<br /><br />当前位置：" + js_lat_lng[i].current_location + "<br />已停留时间：" + js_lat_lng[i].stay_time;

        // 是否异常，异常内容
        if (js_lat_lng[i].is_anomaly > 0) {
            var content = js_lat_lng[i].driver_name + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + "<br />" + js_lat_lng[i].driver_mobile + "<br /><br />" + js_lat_lng[i].anomaly_desc + "";
        }

        // 添加标注
        map.addOverlay(marker);
        addMouseHandler(content,marker);

        // 显示司机姓名
        var label = new BMap.Label(js_lat_lng[i].driver_name,{offset:new BMap.Size(20,-18)});
        marker.setLabel(label);
    };

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