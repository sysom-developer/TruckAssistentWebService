<div class="s_class">
    <div class="sclass_left">
        <ul>
            <li <?php if ($order_type == 997) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/vehicle/vehicle_list/?order_type=997')?>">车队信息</a></li>
            <li <?php if ($order_type == 4) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/vehicle/?order_type=4')?>">在途车辆</a></li>
            <li <?php if ($order_type == 998) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/vehicle/sleep_vehicle/?order_type=998')?>">可用车辆</a></li>
        </ul>
    </div>
    <div class="sclass_middle" style="position:absolute;width:350px;left:350px;">
        <ul>
            <li <?php if ($order_type == 999) { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/order/history_order/?order_type=999')?>">我的运单</a></li>
            <li><a href="javascript:;" class="add-car">十 添加车辆</a></li>
            <li><a href="javascript:;" class="assign_order">十 添加运单</a></li>
        </ul>
    </div>
</div>