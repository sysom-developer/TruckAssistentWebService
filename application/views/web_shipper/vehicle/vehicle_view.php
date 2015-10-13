<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<script type="text/javascript">
$(function() {
    window.placeholder();
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="editorcontent" style="display:none">
    <?php $this->load->view($this->appfolder.'/order/detail_order_view')?>

    <?php $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/publish_order_view')?>

    <?php $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/publish_vehicle_view')?>

    <?php $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/vehicle_map_view')?>
</div>

<div class="mask" style="display:none"></div>

<div class="container">

    <?php $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/vehicle_top_view')?>

    <div class="order carlist">
        <ul class="white listtitle"> 
            <li>司机姓名</li> 
            <li>车牌号码</li> 
            <li>始发城市 </li> 
            <li>目的城市</li> 
            <li>当前位置</li> 
            <li>
                <?php
                if ($order_type == 4) {
                    echo '预计到达时间';
                } elseif ($order_type == 3) {
                    echo '预计发车时间';
                }
                ?>                
            </li> 
            <li>运单状态</li> 
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
            <!-- <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['driver_data']['driver_name'].'('.$data['driver_data']['driver_mobile'].')'?></li> -->
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_name']?></span></li>
            <!-- <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['vehicle_data']['vehicle_card_num'].'('.$data['vehicle_type_data']['type_name'].$data['vehicle_data']['vehicle_length'].'米)'?></li> -->
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['vehicle_data']['vehicle_card_num']?></span></li>
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_start_city']?></span></li> 
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_end_city']?></span></li> 
            <li class="show-order-detail"style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"  order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['current_location']?></span></li> 
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;">
                <?php
                if ($order_type == 4) {
                    echo date('m-d H:i', $data['good_end_time']);
                } elseif ($order_type == 3) {
                    echo date('m-d H:i', $data['good_start_time']);
                }
                ?>
				</span>
            </li> 
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;">
                <?php
                if ($order_type == 4) {
                    echo '<span style="color: #006400;">在途</span>';
                } elseif ($order_type == 3) {
                    echo '<span style="color: #006400;">待运</span>';
                }
                ?>
				</span>
            </li> 
            <li id="oper"style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" ><span style="display:table-cell;vertical-align: middle;">
                <a href="javascript:;" name="assign_order" driver_id="<?php echo $data['driver_id']?>" vehicle_id="<?php echo $data['vehicle_id']?>">
                    <img src="<?php echo static_url('static/images/'.$this->appfolder.'/set.png')?>" />
                </a>
				</span>
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