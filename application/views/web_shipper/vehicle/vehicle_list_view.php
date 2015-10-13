<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<script type="text/javascript">
$(function() {
    window.placeholder();

    // 删除车辆
    $('.del-vehicle-btn').click(function() {
        var vehicle_id = $(this).attr('vehicle_id');

        $('.del-vehicle-confirm[vehicle_id='+vehicle_id+']').show();
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

</div>

<div class="mask" style="display:none"></div>

<div class="container">

<?php $this->load->view($this->appfolder.'/'.$this->router->fetch_class().'/vehicle_top_view')?>

    <div class="order carlist">
        <ul class="white listtitle"> 
            <li>司机信息</li> 
            <li>联系方式</li> 
            <li>车牌号码</li> 
            <li>当前位置</li> 
            <li>状态</li> 
            <li>合作次数</li> 
            <li>创建时间</li> 
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
            <li id="carer" >
                <a href="<?php echo $data['driver_head_icon_http_file']?>" target="_blank">
                    <span><img src="<?php echo $data['driver_head_icon_http_file']?>" width="40" height="40"></span>
                    <span><?php echo $data['driver_data']['driver_name']?></span>
                </a>
            </li> 
            <li style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_mobile']?></li> 
            <li style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['vehicle_card_num']?></span></li> 
            <li style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['current_location']?></span></li> 
            <li style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_type']?></span></li> 
            <li style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_count']?></span></li> 
            <li style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"><span style="display:table-cell;vertical-align: middle;"><?php echo date('Y-m-d', $data['driver_data']['create_time'])?></li> 
            <li id="oper">
                <span class="oper_editor" vehicle_id="<?php echo $data['vehicle_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/send.png')?>" ></span>
                <span class="oper_del del-vehicle-btn" vehicle_id="<?php echo $data['vehicle_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/del.png')?>" ></span>
                <div class="del_layer del-vehicle-confirm" vehicle_id="<?php echo $data['vehicle_id']?>">
                    <input type="submit" class="confirm" value="确定" vehicle_id="<?php echo $data['vehicle_id']?>">
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