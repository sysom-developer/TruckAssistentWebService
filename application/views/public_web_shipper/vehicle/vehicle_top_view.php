<script type="text/javascript">
var map_green_vehicle_url = '<?php echo static_url("static/images/'+appfolder+'/history_map_green_vehicle.png")?>';
var map_red_vehicle_url = '<?php echo static_url("static/images/'+appfolder+'/history_map_red_vehicle.png")?>';

var start_location_icon_url = '<?php echo static_url("static/images/'+appfolder+'/start_location_icon.png")?>';
var end_location_icon_url = '<?php echo static_url("static/images/'+appfolder+'/end_location_icon.png")?>';

var map_red_anomaly_icon_url = '<?php echo static_url("static/images/'+appfolder+'/map_red_anomaly_icon.png")?>';

var order_type = '<?php echo $order_type?>';
$(function() {
    $("select[name=order_type]").change(function() {
        var order_type = $(this).val();

        if (order_type == '998') {
            window.location.href = apppath+fetch_class+'/sleep_vehicle/?order_type='+order_type;
        } else {
            window.location.href = apppath+fetch_class+'/?order_type='+order_type;
        }
    });

    // 隐藏层
    $(".close, .cancel").click(function(){
        $(".orderedit").hide(); // 新增运单
        $(".editcar").hide();   // 添加车辆
        $(".map").hide();   // 地图

        $(".mask").hide();
        $(".editorcontent").hide();

        $(".head").removeClass("fixed");
        $(".container").removeClass("serachfixed");
    });
});
</script>
<div class="serach">
    <div class="s_blank">
        <form name="vehicle_search_form" action="<?php echo site_url($this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/')?>" method="get">
        <input type="hidden" name="order_type" value="<?php echo $order_type?>">
        <span>
            <input name="k" type="text" val="请输入司机名称" value="<?php echo !empty($k) ? $k : '请输入司机名称'?>" class="so placeholder">
            <input name="submit" type="submit" value="" class="serachin"/>
        </span>
        </form>
    </div>
</div>

<?php $this->load->view($this->appfolder.'/vehicle/public_vehicle_top_view')?>