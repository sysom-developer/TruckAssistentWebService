<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<style type="text/css">
.order li {width: 8%;}
</style>

<script type="text/javascript">
function showeditor(){
    $(".mask").show();
    $(".editorcontent").show();
    $(".head").addClass("fixed");
    $(".container").addClass("serachfixed");
}
function del(a){
    a.css("display","none");
}

$(function() {
    window.placeholder();

    // 删除运单
    $(".order-delete").click(function() {
        var order_id = $(this).attr('order_id');

        $('.order-edit[order_id='+order_id+']').hide();
        $(this).hide();
        $('.del-confirm-btn[order_id='+order_id+']').show();
    });
    // 确定删除
    $('.del-confirm-btn-yes').click(function() {
        var order_id = $(this).attr('order_id');

        $.post(apppath + 'draft/ajax_delete_order', {order_id: order_id}, function(json) {
            if (json.code == 'success') {
                window.setTimeout("window.location.reload();", 1000);
            } else {
                return false;
            }
        }, 'json');

        return false;
    });
    // 取消删除运单
    $('.del-confirm-btn-no').click(function() {
        var order_id = $(this).attr('order_id');

        $('.order-edit[order_id='+order_id+']').show();
        $('.order-delete[order_id='+order_id+']').show();
        $('.del-confirm-btn[order_id='+order_id+']').hide();
    });
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="editorcontent" style="display:none;">
    <?php $this->load->view($this->appfolder.'/order/detail_order_view')?>

    <?php $this->load->view($this->appfolder.'/order/edit_order_view')?>
</div>
<div class="mask" style="display:none;"></div>

<div class="container" >
    <div class="serach">
        <div class="serach_select">
            <select class="search-select" name="search_type">
                <option value="create_time">创建时间</option>
            </select>
        </div>
        
        <div class="serach_blank">
            <form name="draft_order_search_form" action="<?php echo site_url($this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/')?>" method="get">
            <span>
                <input name="k" type="text" val="请输入司机名称" value="<?php echo !empty($k) ? $k : '请输入司机名称'?>" class="so placeholder">
                <input name="submit" type="submit" value="" class="serachin"/>
            </span>
            </form>
        </div>
    </div>

    <div class="order">
        <ul class="white listtitle"> 
            <li>运单编号</li>
            <li>司机名称</li>
            <li>联系电话</li>
            <li>货物名称</li> 
            <li>车辆要求</li> 
            <li>指定货车</li> 
            <li>出发地 </li> 
            <li>目的地</li> 
            <li>预计发车时间</li>
            <li><!--  class="px" -->
                创建时间
                <!-- &nbsp;&nbsp;
                <span>
                    <p>
                        <a href="">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/uparrow.png')?>">
                        </a>
                    </p>
                    <p>
                        <a href="">
                            <img src="<?php echo static_url('static/images/'.$this->appfolder.'/downarrow.png')?>">
                        </a>
                    </p>
                </span> -->
            </li>
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
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><a href="javascript:;"><?php echo $data['order_num']?></a></li>
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['driver_data']['driver_name']?></li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['driver_data']['driver_mobile']?></li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['good_name']?></li>
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['vehicle_type_data']['type_name'].$data['vehicle_data']['vehicle_length']?>米</li>
            <li>指定货车</li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['order_start_city']?></li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['order_end_city']?></li>  
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo date('m-d H:i', $data['good_start_time'])?></li>
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo date('m-d H:i', $data['create_time'])?></li>
            <li id="oper">
                <span class="oper_editor order-edit" order_id="<?php echo $data['order_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/editor.png')?>" /></span>
                <span class="oper_del order-delete" order_id="<?php echo $data['order_id']?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/del.png')?>" /></span>
                <div class="del_layer del-confirm-btn" order_id="<?php echo $data['order_id']?>">
                    <input type="submit" class="confirm del-confirm-btn-yes" order_id="<?php echo $data['order_id']?>" name="yes_<?php echo $data['order_id']?>" order_id="<?php echo $data['order_id']?>" value="确定">
                    <input type="button" class="delcancel del-confirm-btn-no" order_id="<?php echo $data['order_id']?>" name="no_<?php echo $data['order_id']?>" value="取消">
                </div>
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