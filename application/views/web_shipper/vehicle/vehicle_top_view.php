<script type="text/javascript">
var order_type = '<?php echo $order_type?>';
var search_type = '<?php echo $search_type?>';
$(function() {
    $("select[name=order_type]").change(function() {
        var order_type = $(this).val();

        if (order_type == '998') {
            window.location.href = apppath+fetch_class+'/sleep_vehicle/?order_type='+order_type+'&search_type='+search_type;
        } else {
            window.location.href = apppath+fetch_class+'/?order_type='+order_type+'&search_type='+search_type;
        }
    });

    $("select[name=search_type]").change(function() {
        var search_type = $(this).val();

        window.location.href = apppath+fetch_class+'/?search_type='+search_type+'&order_type='+order_type;
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
    <div class="s_select">
        <?php
        if ($this->router->fetch_method() == 'index') {
        ?>
        <select class="search-select" name="search_type" style="float: left;">
            <option value="good_end_time" <?php if ($search_type == 'good_end_time') { echo 'selected';}?>>预计到达时间</option>
            <option value="order_start_city" <?php if ($search_type == 'order_start_city') { echo 'selected';}?>>出发城市</option>
            <option value="order_end_city" <?php if ($search_type == 'order_end_city') { echo 'selected';}?>>目的地城市</option>
        </select>
        <?php
        }
        ?>
        <div class="point" <?php if ($this->router->fetch_method() != 'index') { echo'style="margin-left: 0;"';}?>>我的车队—共 <span class="red"><?php echo $vehicle_count?></span> 辆货车，<?php echo $carry_count?> 辆在途，<?php echo $wait_count?> 辆待运，<?php echo $sleep_count?> 辆可用</div>
    </div>
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

<div class="s_class">
    <div class="sclass_left">
        <ul>
            <li <?php if ($order_type == 997) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/vehicle/vehicle_list/?order_type=997&search_type='.$search_type.'')?>">车队信息</a></li>
            <li <?php if ($order_type == 4) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/vehicle/?order_type=4&search_type='.$search_type.'')?>">在途车辆</a></li>
            <li <?php if ($order_type == 3) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/vehicle/?order_type=3&search_type='.$search_type.'')?>">待运车辆</a></li>
            <li <?php if ($order_type == 998) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/vehicle/sleep_vehicle/?order_type=998&search_type='.$search_type.'')?>">可用车辆</a></li>
        </ul>
    </div>
    <div class="sclass_right">
        <?php
        if ($this->router->fetch_method() != 'vehicle_list' && $this->router->fetch_method() != 'sleep_vehicle') {
        ?>
        <a href="<?php echo site_url($this->appfolder.'/'.$this->router->fetch_class().'/calendar')?>">
            <span id="serachcal">
                <img src="<?php echo static_url('static/images/'.$this->appfolder.'/rili.png')?>">
                calendar
            </span>
        </a>
        <a href="javascript:;" class="show-vehilce-top-map">
            <span id="serachmap">
                <img src="<?php echo static_url('static/images/'.$this->appfolder.'/mapicon.png')?>">
                地图
            </span>
        </a>
        <?php
        } else {
        ?>
        <a href="javascript:;" class="add-car">
            <span id="addcar">+ 添加车辆</span>            
        </a>
        <?php
        }
        ?>
    </div>
</div>