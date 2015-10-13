<div class="map detail-map" style="display: none;">
    <div class="close"></div>
    <div class="mapnr" style="height: 600px;" id="detail_baidu_allmap">
    </div>
</div>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo BAIDU_AK?>"></script>

<script type="text/javascript">
$(function() {
    // 显示指派运单层
    $(".show-detail-map").click(function() {
        $(".order_detail").hide();

        $(".detail-map").show();

        $(".mask").show();
        $(".editorcontent").show();

        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });
});

// 百度地图API功能
var map = new BMap.Map("detail_baidu_allmap");
var point = new BMap.Point(116.404, 39.915);
map.centerAndZoom(point, 15);

//向地图添加控件
var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,type:0});
map.addControl(navControl);
map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

var marker = new BMap.Marker(point);  // 创建标注
map.addOverlay(marker);               // 将标注添加到地图中
marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
</script>