<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<script type="text/javascript">
var order_id = 0;
$(function() {
    window.placeholder();

    // 删除运单
    $('.del-order-btn').click(function() {
        var order_id = $(this).attr('order_id');

        $('.send-vehicle-message-btn[order_id='+order_id+']').hide();
        $(this).hide();
        $('.del-order-confirm-html[order_id='+order_id+']').show();
    });

    // 取消 删除运单
    $('.cancel-del-order-confirm').click(function() {
        var order_id = $(this).attr('order_id');

        $('.send-vehicle-message-btn[order_id='+order_id+']').show();
        $('.del-order-btn[order_id='+order_id+']').show();
        $('.del-order-confirm-html[order_id='+order_id+']').hide();
    });

    // 确认 删除运单
    $('.ok-del-order-confirm').click(function() {
        var order_id = $(this).attr('order_id');

        alert(order_id);
    });
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="editorcontent" style="display:none">
    <?php $this->load->view($this->appfolder.'/order/detail_order_view')?>

    <?php $this->load->view($this->appfolder.'/order/history_order_driver_route_map_view')?>

    <?php $this->load->view($this->appfolder.'/vehicle/publish_vehicle_view')?>

    <?php $this->load->view($this->appfolder.'/vehicle/publish_order_view')?>

    <?php $this->load->view($this->appfolder.'/vehicle/send_vehicle_message_view')?>
</div>

<div class="mask" style="display:none;"></div>

<div class="container" >
    
    <?php $this->load->view($this->appfolder.'/order/history_order_top_view')?>

    <div class="order historyorder">
        <ul class="white listtitle"> 
            <li>运单编号</li> 
            <li>司机姓名</li> 
            <li>联系方式</li> 
            <li>车牌号码</li> 
            <li>出发地 </li> 
            <li>目的地</li> 
            <li class="px">
                创建时间
                &nbsp;
                <span class="up" style="display: none;">
                    <p>
                        <a href="javascript:;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/uparrow.png')?>"></a>
                    </p>
                </span>
                <span class="down">
                    <p>
                        <a href="javascript:;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/downarrow.png')?>"></a>
                    </p>
                </span>
            </li> 
            <li>状态</li> 
            <li id="oper">操作</li>
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
            <li style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><a href="javascript:;"><?php echo $data['order_num']?></a></span></li> 
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_name']?></span></li> 
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_mobile']?></span></li>
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['vehicle_data']['vehicle_card_num']?></span></li>
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_start_city']?></span></li>
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_end_city']?></span></li>
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo date('m-d H:i', $data['create_time'])?></span></li> 
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_type']?></span></li>
            <li>
                <span class="oper_editor send-vehicle-message-btn" order_id="<?php echo $data['order_id']?>" driver_id="<?php echo $data['driver_data']['driver_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/send.png')?>" ></span>
                <!-- <span class="oper_del del-order-btn" order_id="<?php echo $data['order_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/del.png')?>" ></span>
                <div style="display: none;" class="del_layer del-order-confirm-html" order_id="<?php echo $data['order_id']?>">
                    <input type="submit" class="confirm ok-del-order-confirm" value="确定" order_id="<?php echo $data['order_id']?>" style="width: 60px;">
                    <input type="button" class="delcancel cancel-del-order-confirm" value="取消" order_id="<?php echo $data['order_id']?>" style="width: 60px;">
                </div> -->
            </li> 
        </ul>
        <?php
                $i++;
            }
        }
        ?>
    </div> 
    <div class="page">
        <?php echo $links?>
        共 <?php echo $total?> 条记录 显示 <?php echo $cur_page_num?> / <?php echo $total_page_num?>
    </div>
</div>

</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>