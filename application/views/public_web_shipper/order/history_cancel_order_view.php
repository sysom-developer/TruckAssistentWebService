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
</div>
<div class="mask" style="display:none;"></div>

<div class="container" >
    
    <?php $this->load->view($this->appfolder.'/order/history_order_top_view')?>

    <div class="order historyorder">
        <ul class="white listtitle"> 
            <li>运单编号</li>
            <li>运单来源</li>
            <li>货物名称</li>
            <li>取消人</li>
            <li>取消原因</li>
            <li>
                取消时间
            </li>
            <li id="oper_k">操作</li> 
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
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><a onclick="showorder()"><?php echo $data['order_num']?></a></li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['order_type_text']?></li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['good_name']?></li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>">货主</li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>">删除</li> 
            <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"> 4-18 15:00</li> 
            <li id="oper_k">
                
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