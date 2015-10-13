<div class="serach">
    <div class="serach_select">
        <?php
        if ($history_type == 1) {
        ?>
        <div style="float: left;">
            <select class="search-select" name="search_type">
                <option value="good_start_time">发车时间</option>
            </select>
        </div>
        <?php
        }
        ?>
        <div class="serach_order">
            <a href="<?php echo site_url($this->appfolder.'/order/history_order/?history_type=1')?>"><span <?php if ($history_type == 1) { echo 'class="current"';}?>>已完成运单</span></a>
            <a href="<?php echo site_url($this->appfolder.'/order/history_order/?history_type=2')?>"><span <?php if ($history_type == 2) { echo 'class="current"';}?>>已取消运单</span></a>
         </div>
    </div>
</div>

<?php
if ($history_type == 1) {
?>
<!-- jquery ui -->
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/jquery-ui-timepicker-addon.css')?>">
<script type="text/javascript" src="<?php echo static_url('static/js/jquery-ui.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.ui.datepicker-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/address_autocomplete.js')?>"></script>

<script type="text/javascript">
$(function() {
    $("input[name=start_time]").mousedown(function() {
        $(this).datepicker();
    });
    $("input[name=end_time]").mousedown(function() {
        $(this).datepicker();
    });
});
</script>

<form action="" method="get">
<div class="serach_term">
    <ul>
        <li style="left:0;">
            <label>车主姓名：</label>
            <input type='text' name='k' class='input placeholder' style="width: 130px; background: #fff;" val='请输入司机名称' value='请输入司机名称'>
         </li>
         <li style="left:26%">
            <label>货运路线：</label>
            <select class="select_h" name="shipper_route_id">
                <option value='all' <?php if ($shipper_route_id == 'all') { echo 'selected';}?>>全部</option>
                <?php echo $get_shipper_route_options?>
            </select>
         </li>
         <li style="right:26%">
            <label>实际发车开始时间：</label>
            <input type="text" name="start_time" class="input" style="width: 130px; background: #fff;" value='<?php echo $start_time ? date('Y-m-d', $start_time) : ''?>'>
        </li>
        <li style="right:0;">
            <label>实际发车结束时间：</label>
            <input type="text" name="end_time" class="input" style="width: 130px; background: #fff;" value='<?php echo $end_time ? date('Y-m-d', $end_time) : ''?>'>
        </li>
        <li style="text-align:center;"><label>&nbsp;</label>   
            <input type="button" value="全部运单" class="allorder" onclick='javascript: window.location.href="<?php echo site_url($this->appfolder.'/order/history_order')?>";'>
        </li>
        <li style="text-align:right;"><label>&nbsp;</label>   
            <input type="submit" value="开始查询" class="ordersubmit">
        </li>
     </ul>
</div>
</form>

<div class="countorder">累计完成运单：<?php echo $all_count?>单&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;累计运费：<?php echo $all_freight?>万</div>
<?php
}
?>