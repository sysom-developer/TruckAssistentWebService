<div class="map vehicle-top-map" style="display: none;">
	<div class="close">
		<div class="map_tagging">
		<p><img src="C:\www\tuhaoyun\static\images\public_web_shipper\map_red_vehicle_2.png"/>在途车辆</p>
		<p><img src="C:\www\tuhaoyun\static\images\public_web_shipper\map_green_vehicle_2.png"/>可用车辆</p>
	</div>
	</div>
    <div class='vehicle-map-loading' style="padding-top: 20px; text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>
    <div class="mapnr" style="height: 600px;" id="vehicle_top_map_div">
    </div>
</div>

<script type="text/javascript">
$(function() {
    $(".show-vehilce-top-map").click(function() {
        $(".vehicle-map-loading").show();

        loadVehicleMapJScript();

        $(".vehicle-top-map").show();

        $(".mask").show();
        $(".editorcontent").show();

        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });
});

//百度地图API功能
function loadVehicleMapJScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://api.map.baidu.com/api?v=2.0&ak="+baidu_ak+"&callback=init_vehicle_map";
    document.body.appendChild(script);
}
function init_vehicle_map() {
    var map = new BMap.Map("vehicle_top_map_div");  // 创建Map实例
    window.setTimeout(function(){
        map.centerAndZoom("武汉", 6);
    }, 300);  // 延迟放大

    // 加载完成事件
    map.addEventListener("tilesloaded",function() {
        $(".vehicle-map-loading").hide();
    });

    map.addControl(new BMap.MapTypeControl());   //添加地图类型控件

    //向地图添加控件
    var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,type:0});
    map.addControl(navControl);
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

    var js_lat_lng = <?php echo $js_lat_lng?>;
    for (var i = js_lat_lng.length - 1; i >= 0; i--) {
        // 添加标注
        var point = new BMap.Point(js_lat_lng[i].lng, js_lat_lng[i].lat);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);

        // 标注文字
        var label_text = js_lat_lng[i].driver_name + "<br />" + js_lat_lng[i].driver_mobile;
        var label = new BMap.Label(label_text,{offset:new BMap.Size(13,-50)});
        marker.setLabel(label);
        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
    };
}
</script>