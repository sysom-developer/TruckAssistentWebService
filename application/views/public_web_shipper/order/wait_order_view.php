<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<script type="text/javascript">
$(function() {
    window.placeholder();

    // 状态不同，按钮操作不同
    $('.edit-draft-order-submit[order_type=2]').val('保存运单');
    $('.edit-draft-order-submit[order_type=2]').attr('order_type', 3);
    $('.edit-draft-order-submit[order_type=1]').hide();
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="editorcontent" style="display:none">
    <?php $this->load->view($this->appfolder.'/order/detail_order_view')?>

    <?php $this->load->view($this->appfolder.'/order/edit_order_view')?>
</div>
<div class="mask" style="display:none;"></div>

<div class="container" >
    <div class="serach">
        <div class="serach_select">
            <select class="search-select" name="search_type">
                <option value="create_time">要求到达时间</option>
            </select>
        </div>
        
        <div class="serach_blank">
            <form name="search_form" action="<?php echo site_url($this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/')?>" method="get">
            <span>
                <input name="k" type="text" val="请输入司机名称" value="<?php echo !empty($k) ? $k : '请输入司机名称'?>" class="so placeholder">
                <input type="submit" value="" class="serachin"/>
            </span>
            </form>
        </div>
    </div>

    <div class="order yj">
        <ul class="white listtitle"> 
            <li>运单编号</li> 
            <li>司机姓名</li> 
            <li>车牌号码</li> 
            <li>车辆信息    </li> 
            <li>出发地 </li> 
            <li>目的地</li> 
            <li>当前位置</li> 
            <li>预计发车时间</li> 
            <li class="px">
                要求到达时间
                &nbsp;
                <span class="up">
                    <p>
                        <a href="javascript:;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/uparrow.png')?>"></a>
                    </p>
                </span>
                <span class="down" style="display: none;">
                    <p>
                        <a href="javascript:;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/downarrow.png')?>"></a>
                    </p>
                </span>
            </li> 
            <li>操作</li>
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
            <li class="show-order-detail"style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"  order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><a href="javascript:;"><?php echo $data['order_num']?></a></span></li> 
            <!-- <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['driver_data']['driver_name'].'('.$data['driver_data']['driver_mobile'].')'?></li> -->
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_name']?></span></li>
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['vehicle_data']['vehicle_card_num']?></span></li> 
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['vehicle_type_data']['type_name'].$data['vehicle_data']['vehicle_length']?>米</span></li> 
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_start_city']?></span></li>
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_end_city']?></span></li>
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['current_location']?></span></li> 
            <li class="show-order-detail"style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"  order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo date('m-d H:i', $data['good_start_time'])?></span></li> 
            <li class="show-order-detail" style="width: 122px;display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo date('m-d H:i', $data['good_end_time'])?></span></li> 
            <li style="width: 122px;display:table;height:60px;table-layout:fixed; >
                <span class="oper_editor order-edit"  style="display:table-cell;vertical-align: middle;word-break:break-all; word-wrap:break-word" order_id="<?php echo $data['order_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/editor.png')?>" /></span>
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