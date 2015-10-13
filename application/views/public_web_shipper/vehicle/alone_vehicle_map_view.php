<div id"alone_vehicle_map" class="alone_vehicle_map">
    <div class='alone-vehicle-map-loading' style="padding-top: 20px; text-align: center;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
    </div>
    <div style="width:100%;height:580px;border:#ccc solid 1px;" id="map_alone_vehicle_div"></div>
	<div class="alone_map_tagging alone-vehicle-map-tip" style="display: none;">
        <span class="tagging_green">60km/h以上</span>
        <span class="tagging_orang">40-60km/h</span>
		<span class="tagging_red">40km/h以下</span>
    </div>
    <div class="map_route alone-vehicle-map-tip" style="display: none;">
        <p>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_green_vehicle_2.png')?>"/>
            <span id="start_company_name_span"></span>
        </p>
        <p>
            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_red_vehicle_2.png')?>"/>
            <span id="end_company_name_span"></span>
        </p>
    </div>
</div>
<div class="alone_map_right alone-vehicle-map-tip" style="display: none;">

	<div class="frame_arrow alone-vehicle-track-arrow">
		<img src="<?php echo static_url('static/images/'.$this->appfolder.'/arrow_2.png')?>"/>
    </div>
	<!--frame_arrow -->

	<div class="frame alone-vehicle-track-html">
		<img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_right_frame.png')?>"/>

		<div class="frame_line"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_line_2.png')?>"/>
		</div><!--frame_line -->

		<div class="frame_list">
			<div class="frame_list_left">
				<ul id="track_desc_html">
                    <!-- <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_green_vehicle_3.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot_red">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_red_vehicle_2.png')?>"/>
                        </span>
                        <span class="fame_text">车辆</span>
                        <p>今天21:00</p>
                        <div class="frame_list_left_img">
                            <a href="#"><img src=""/></a>
                            <a href="#"><img src=""/></a>
                        </div>
                    </li>
                    <li>
                        <span class="frame_dot_red">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_red_vehicle_2.png')?>"/>
                        </span>
                        <span class="fame_text">车辆</span>
                        <p>今天21:00</p>
                        <div class="frame_list_left_img">
                            <a href="#"><img src=""/></a>
                            <a href="#"><img src=""/></a>
                            <a href="#"><img src=""/></a>
                            <a href="#"><img src=""/></a>
                            <a href="#"><img src=""/></a>
                            <a href="#"><img src=""/></a>
                        </div>
                    </li>
                    <li>
                         <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
						<span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li>
                    <li>
                        <span class="frame_dot">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/map_grey_vehicle.png')?>"/>
                        </span>
                        <span class="fame_text">车辆到达安徽省合肥市</span>
                        <p>今天21:00</p>
                    </li> -->
				</ul>
			</div><!--frame_list_left -->
		</div><!--frame_list -->
	</div><!--frame -->
 </div><!--alone_map_right -->

<script type="text/javascript">
var order_id = <?php echo $order_id?>;
var driver_data = '';
var track_data_list = 'undefined';
var order_data = '';
var order_type_desc = '';
var current_lat = '';
var current_lng = '';
var current_location = '';
var is_anomaly = '';
var anomaly_desc = '';
$(".alone-vehicle-map-loading").show();
$(function() {
    var arrow_2_img = "<?php echo static_url('static/images/"+appfolder+"/arrow_2.png')?>";
    var arrow_3_img = "<?php echo static_url('static/images/"+appfolder+"/arrow_3.png')?>";
    $('.alone-vehicle-track-arrow').click(function() {
        $('.alone-vehicle-track-html').toggle('slow',
            function() {
                if ($('.alone-vehicle-track-html').css('display') == 'none') {
                    $('.alone-vehicle-track-arrow').find('img').attr('src', arrow_3_img);
                    $('.alone-vehicle-track-arrow').css("right", "0");
                }
                if ($('.alone-vehicle-track-html').css('display') == 'block') {
                    $('.alone-vehicle-track-arrow').find('img').attr('src', arrow_2_img);
                    $('.alone-vehicle-track-arrow').css("right", "398px");
                }
            }
        );
    });

    $.post(apppath + 'order/ajax_get_track_driver_route', {order_id: order_id}, function(json) {
        if (json.code == 'success') {
            driver_data = json.driver_data;
            order_data = json.order_data;
            order_type_desc = json.order_type_desc;
            current_lat = json.current_lat;
            current_lng = json.current_lng;
            current_location = json.current_location;
            is_anomaly = json.is_anomaly;
            anomaly_desc = json.anomaly_desc

            track_data_list = json.track_data_list;

            var start_company_name_span = order_data.order_start_city+order_data.good_load_addr;
            start_company_name_span = start_company_name_span.substring(0, 28)+'...';
            var end_company_name_span = order_data.order_end_city+order_data.good_unload_addr;
            end_company_name_span = end_company_name_span.substring(0, 28)+'...';
            $('#start_company_name_span').html(start_company_name_span);
            $('#end_company_name_span').html(end_company_name_span);

            loadAloneVehicleMapJScript();
        } else {
            alert(json.code);
            return false;
        }
    }, 'json');
});

function loadAloneVehicleMapJScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://api.map.baidu.com/api?v=2.0&ak="+baidu_ak+"&callback=init_alone_vehicle_map";
    document.body.appendChild(script);
}
function init_alone_vehicle_map() {
    var map = new BMap.Map("map_alone_vehicle_div");  // 创建Map实例
    
    // 加载完成事件
    map.addEventListener("tilesloaded",function() {
        // 地图加载完成显示轨迹
        $.post(apppath + 'order/ajax_get_order_detail', {order_id: order_id, show_interval_track: 1}, function(json) {
            if (json.code == 'success') {
                var track_gray_img = "<?php echo static_url('static/images/"+appfolder+"/map_grey_vehicle.png')?>";
                var track_red_img = "<?php echo static_url('static/images/"+appfolder+"/map_red_vehicle_2.png')?>";
                var track_green_img = "<?php echo static_url('static/images/"+appfolder+"/map_green_vehicle_3.png')?>";

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
                                <span class="frame_dot_red"> \
                                    <img src="'+track_red_img+'"/> \
                                </span> \
                                <span class="fame_text">'+driver_anomaly_text+'</span> \
                                <p>'+driver_anomaly[j].cretime+'</p> \
                                <div class="frame_list_left_img">'+driver_anomaly_img_html+'</div> \
                            </li>'; 
                        };
                    }

                    if (json.track_data.track_log[i].track_desc == '运单完成') {
                        track_desc_html += ' \
                        <li> \
                            <span class="frame_dot"> \
                                <img src="'+track_green_img+'"/> \
                            </span> \
                            <span class="fame_text">'+json.track_data.track_log[i].track_desc+'</span> \
                            <p>'+json.track_data.track_log[i].track_time+'</p> \
                        </li>';
                    } else {
                        track_desc_html += ' \
                        <li> \
                            <span class="frame_dot"> \
                                <img src="'+track_gray_img+'"/> \
                            </span> \
                            <span class="fame_text">'+json.track_data.track_log[i].track_desc+'</span> \
                            <p>'+json.track_data.track_log[i].track_time+'</p> \
                        </li>';
                    }
                };
                $('#track_desc_html').html(track_desc_html);
            } else {
                return false;
            }
        }, 'json');

        $(".alone-vehicle-map-loading").hide();
        $(".alone-vehicle-map-tip").show();
    });

    //向地图添加控件
    var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,type:0});
    map.addControl(navControl);
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

    start_lat = order_data.start_location_lat;
    start_lng = order_data.start_location_lng;
    end_lat = order_data.end_location_lat;
    end_lng = order_data.end_location_lng;

    // 起点
    var first_poi = new BMap.Point(start_lng, start_lat);
    var startMarkerIcon = new BMap.Icon(start_location_icon_url, new BMap.Size(42,52));
    
    // 终点
    var last_poi = new BMap.Point(end_lng, end_lat);
    var endMarkerIcon = new BMap.Icon(end_location_icon_url, new BMap.Size(42,52));

    // 距离
    var pointA = new BMap.Point(current_lng,current_lat);
    var pointB = new BMap.Point(end_lng,end_lat);
    // 转换公里
    distance_meter = map.getDistance(pointA,pointB).toFixed(2);
    distance_km = 0;
    if (distance_meter > 0) {
        km = distance_meter / 1000;
        distance_km = km.toFixed(1)+'公里';
    }
    order_type_desc = "<br />剩余里程：" + distance_km;

    var i = 0;
    if (track_data_list != "undefined") {
        for (; i < track_data_list.length; i++) {
            j = i + 1;

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

    var start_marker = new BMap.Marker(first_poi,{icon:startMarkerIcon});  // 创建标注
    map.addOverlay(start_marker);              // 将标注添加到地图中

    var end_marker = new BMap.Marker(last_poi,{icon:endMarkerIcon});  // 创建标注
    map.addOverlay(end_latmarker);              // 将标注添加到地图中

    // 是否异常
    var markerIconUrl = map_red_vehicle_url;
    if (is_anomaly > 0) {
        markerIconUrl = map_red_anomaly_icon_url;
    }

    // 当前位置
    var curMarkerIcon = new BMap.Icon(markerIconUrl, new BMap.Size(35,58));
    var opts = {
        width : 200,     // 信息窗口宽度
        height: 150,     // 信息窗口高度
        title : "" , // 信息窗口标题
        enableMessage:true//设置允许信息窗发送短息
    };
    var point = new BMap.Point(current_lng, current_lat);
    var marker = new BMap.Marker(point,{icon:curMarkerIcon});
    var content = driver_data.driver_name + "<br />" + driver_data.driver_mobile + "<br /><br />" + order_data.order_start_city + ' 至 ' + order_data.order_end_city + "<br />当前位置：" + current_location + order_type_desc + "<br />预计到达时间：" + order_data.good_end_time;

    // 是否异常，异常内容
    if (is_anomaly > 0) {
        var content = driver_data.driver_name + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + "<br />" + driver_data.driver_mobile + "<br /><br />异常情况：" + anomaly_desc + "";
    }

    map.addOverlay(marker);
    addClickHandler(order_id, marker);
    addMouseHandler(content,marker);
    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画

    // 显示司机姓名
    var label = new BMap.Label(driver_data.driver_name,{offset:new BMap.Size(20,-18)});
    marker.setLabel(label);

    map.setViewport([first_poi, last_poi]); // 调整到最佳视野

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
</script>