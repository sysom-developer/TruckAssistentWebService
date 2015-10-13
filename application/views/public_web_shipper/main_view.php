<style>

</style>
<?php $this->load->view($this->appfolder.'/header_view.php')?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<style type="text/css">
.indexcon ul li a { color: white;}
</style>

<script type="text/javascript" src="<?php echo static_url('static/js/Chart.js')?>"></script>
<!--[if lte IE 8]>
<script type="text/javascript" src="<?php echo static_url('static/js/excanvas.js')?>"></script>
<![endif]-->

<script type="text/javascript">
$(function() {
    $(".leftbutton div").each(function(){
        $(this).click(function(){
            $(".leftbutton div").removeClass("current");
            $(this).addClass("current");
        });
    });
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="editorcontent" style="display:none">
    <?php $this->load->view($this->appfolder.'/driver_avg_count_view')?>
</div>

<div class="mask" style="display:none"></div>

<div class="container" >
    <div class="indexcon">
        <ul>
            <!-- <li class="one">
                <a href="<?php echo site_url($this->appfolder.'/order/carry_order')?>">
                    <span class="title">待调度车辆</span>
                    <span class="num"><?php echo $dispatch_count?></span>
                </a>
            </li> -->
            <li class="one">
                <a href="<?php echo site_url($this->appfolder.'/order/carry_order')?>">
                    <span class="title">在途车辆</span>
                    <span class="num"><?php echo $carry_count?></span>
                </a>
            </li>
            <li class="two">
                <a href="<?php echo site_url($this->appfolder.'/vehicle/sleep_vehicle/?order_type=998')?>">
                    <span class="title">可用车辆</span>
                    <span class="num"><?php echo $sleep_count?></span>
                </a>
            </li>
            <li class="three">
                <a href="<?php echo site_url($this->appfolder.'/order/wait_get_order')?>">
                    <span class="title">待接运单</span>
                    <span class="num"><?php echo $wait_get_count?></span>
                </a>
            </li>
            <li class="four">
                <a href="<?php echo site_url($this->appfolder.'/order/wait_order')?>">
                    <span class="title">待运运单</span>
                    <span class="num"><?php echo $wait_count?></span>
                </a>
            </li>
            <li class="five">
                <a href="<?php echo site_url($this->appfolder.'/order/history_order')?>">
                    <span class="title">待评价运单</span>
                    <span class="num"><?php echo $wait_comment_count?></span>
                </a>
            </li>
        </ul>
    </div>
  
    <?php
    if ($echarts_type == 'day') {
        $this->load->view($this->appfolder.'/echarts_day_view.php');
    } elseif ($echarts_type == 'month') {
        $this->load->view($this->appfolder.'/echarts_month_view.php');
    }
    ?>

    <div class="alarm">
        <h2>司机排行版</h2>
        <div class="countlist" >
            <ul class="hui" style="line-height:60px;">
                <li style="width: 122px;">司机姓名</li>
                <li style="width: 122px;">联系方式</li>
                <li style="width: 122px;">车牌号码</li>
                <li style="width: 94px;">总发车数量</li>
                <li style="width: 94px;">本月发车</li>
                <li style="width: 95px;">
                    总收入
                </li>
                <li style="width: 94px;" class="px">
                    本月收入
                    &nbsp;
                    <span class="up" style="display: none; left: 70px;">
                        <p>
                            <a href="javascript:;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/uparrow.png')?>"></a>
                        </p>
                    </span>
                    <span class="down" style="left: 70px;">
                        <p>
                            <a href="javascript:;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/downarrow.png')?>"></a>
                        </p>
                    </span>
                </li>
                <li>货主评价</li>
            </ul>
            <?php
            if ($stat_driver_data_list) {
                $i = 1;
                foreach ($stat_driver_data_list as $data) {
                    $ul_class = 'hui';
                    if ($i % 2 == 0) {
                        $ul_class = 'white';
                    }
            ?>
            <ul class="<?php echo $ul_class?>">
                <li class="driver-avg-count-li" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" driver_id="<?php echo $data['driver_id']?>" driver_name="<?php echo $data['driver_name']?>"><img style="padding: 5px 0 0 30px;" src="<?php echo $data['driver_head_icon_http_file']?>" width="50" height="50" align="left"><span style="display:table-cell;vertical-align: middle;">
                    <?php echo $data['driver_name']?>
					</span>
                </li>
                <li class="driver-avg-count-li" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" driver_id="<?php echo $data['driver_id']?>" driver_name="<?php echo $data['driver_name']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_mobile']?></span></li>
                <li class="driver-avg-count-li" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" driver_id="<?php echo $data['driver_id']?>" driver_name="<?php echo $data['driver_name']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo isset($data['vehicle_data']['vehicle_card_num']) ? $data['vehicle_data']['vehicle_card_num'] : '-'?></span></li>
                <li class="driver-avg-count-li" style="width: 94px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" driver_id="<?php echo $data['driver_id']?>" driver_name="<?php echo $data['driver_name']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['count_go_to']?></span></li>
                <li class="driver-avg-count-li" style="width: 94px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" driver_id="<?php echo $data['driver_id']?>" driver_name="<?php echo $data['driver_name']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['month_count_go_to']?></span></li>
                <li class="driver-avg-count-li" style="width: 95px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" driver_id="<?php echo $data['driver_id']?>" driver_name="<?php echo $data['driver_name']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo sprintf('%0.2f', $data['count_good_freight'] / 10000).' 万'?></span></li>
                <li class="driver-avg-count-li" style="width: 94px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" driver_id="<?php echo $data['driver_id']?>" driver_name="<?php echo $data['driver_name']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo sprintf('%0.2f', $data['month_count_good_freight'] / 10000).' 万'?></span></li>
                <li style="width: 94px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" >
					<span style="display:table-cell;vertical-align: middle;">
                    <?php
                    $driver_comment = '';
                    for ($i=1; $i<=5; $i++) {
                        if ($data['driver_comment'] >= $i) {
                            $driver_comment .= '<img src="'.static_url('static/images/'.$this->appfolder.'/user_star1.png').'">';
                        } else {
                            $driver_comment .= '<img src="'.static_url('static/images/'.$this->appfolder.'/user_star2.png').'">';
                        }
                    }
                    echo $driver_comment;
                    ?>
					</span>
                </li>
            </ul>
            <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>

</body>

<?php $this->load->view($this->appfolder.'/footer_view')?>