<!--引用百度地图API-->
<style type="text/css">
    html,body{margin:0;padding:0;}
    .iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
    .iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<script type="text/javascript">
$(function() {
    window.placeholder();

    $('.carry-vehicle-data-li').click(function() {
        var order_id = $(this).attr('order_id');

        window.location.href = apppath+'vehicle/?order_type=4&order_id='+order_id;
    });

    // 删除车辆
    $('.del-vehicle-btn').click(function() {
        var vehicle_id = $(this).attr('vehicle_id');

        $('.del-vehicle-confirm[vehicle_id='+vehicle_id+']').show();
    });
    // 确定删除
    $('.ok-del-vehicle-confirm').click(function() {
        var driver_id = $(this).attr('driver_id');

        $.post(apppath + 'vehicle/ajax_del_vehicle', {driver_id: driver_id}, function(json) {
            if (json.code == 'success') {
                window.location.reload();
            } else {
                return false;
            }
        }, 'json');
    });
    // 取消删除
    $('.cancel-del-vehicle-confirm').click(function() {
        var vehicle_id = $(this).attr('vehicle_id');

        $('.del-vehicle-confirm[vehicle_id='+vehicle_id+']').hide();
    });
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="editorcontent" style="display:none">

    <?php $this->load->view($this->appfolder.'/vehicle/publish_vehicle_view')?>

    <?php $this->load->view($this->appfolder.'/vehicle/publish_order_view')?>

    <?php $this->load->view($this->appfolder.'/vehicle/send_vehicle_message_view')?>
	
</div>

<div class="mask" style="display:none"></div>

<div class="container">

    <?php $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/vehicle_top_view')?>

    <?php
    // 默认所有司机
    if (empty($order_id)) {
        $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/carry_vehicle_map_view');
    // 单独某个司机
    } else {
        $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/alone_vehicle_map_view');
    }
    ?>
	
    <div class="order carlist">
        <ul class="white listtitle"> 
             <li>司机姓名</li> 
            <li>联系方式</li> 
            <li>车牌号码</li> 
            <li>始发城市</li> 
            <li>目的城市</li> 
            <li>当前位置</li> 
            <li>预计到达时间</li> 
            <li >操作</li> 
        </ul>
        <?php
        if ($data_list) {
            $i = 1;
            foreach ($data_list as $data) {
                $ul_class = 'hui';
                if ($i % 2 == 0) {
                    $ul_class = 'white';
                }
        ?>
        <ul class="<?php echo $ul_class?>">
            <li class="carry-vehicle-data-li" order_id="<?php echo $data['order_data']['order_id']?>" id="carer">
                <a href="<?php echo $data['driver_head_icon_http_file']?>" target="_blank">
                    <span><img src="<?php echo $data['driver_head_icon_http_file']?>" width="40" height="40"></span>
                    <span><?php echo $data['driver_data']['driver_name']?></span>
                </a>
            </li> 
            <li class="carry-vehicle-data-li" order_id="<?php echo $data['order_data']['order_id']?>" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_mobile']?></span></li> 
            <li class="carry-vehicle-data-li" order_id="<?php echo $data['order_data']['order_id']?>" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['vehicle_card_num']?></span></li> 
            <li class="carry-vehicle-data-li" order_id="<?php echo $data['order_data']['order_id']?>" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_data']['order_start_city']?></span></li> 
            <li class="carry-vehicle-data-li" order_id="<?php echo $data['order_data']['order_id']?>" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_data']['order_end_city']?></span></li> 
            <li class="carry-vehicle-data-li" order_id="<?php echo $data['order_data']['order_id']?>" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['current_location']?></span></li> 
            <li class="carry-vehicle-data-li" order_id="<?php echo $data['order_data']['order_id']?>" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo date('m-d H:i', $data['order_data']['good_end_time'])?></span></li> 
            <li id="oper">
                <span class="oper_editor send-vehicle-message-btn" driver_id="<?php echo $data['driver_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/send.png')?>" ></span>
                <span class="oper_del del-vehicle-btn" vehicle_id="<?php echo $data['vehicle_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/del.png')?>" ></span>
                <div class="del_layer del-vehicle-confirm" vehicle_id="<?php echo $data['vehicle_id']?>">
                    <input type="submit" class="confirm ok-del-vehicle-confirm" value="确定" driver_id="<?php echo $data['driver_id']?>" vehicle_id="<?php echo $data['vehicle_id']?>">
                    <input type="button" class="delcancel cancel-del-vehicle-confirm" value="取消" vehicle_id="<?php echo $data['vehicle_id']?>">
                </div>
            </li> 
        </ul>
        <?php
                $i++;
            }
        }
        ?>
    </div> 
    <div class="clearfix">
        <div class="page">
            <?php echo $links?>
            共 <?php echo $total?> 条记录 显示 <?php echo $cur_page_num?> / <?php echo $total_page_num?>
        </div>
    </div>
</div>

</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>