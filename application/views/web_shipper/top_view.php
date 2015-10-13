<script type="text/javascript">
$(function() {
    $(".usermenu").click(function(){
        $(".user_nav").toggle(200);
    });
});
</script>
<!-- 顶部 -->
<div class="head">
    <div class="top">
        <div class="logo floatleft"><a href="<?php echo site_url($this->appfolder)?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/logo.png')?>"></a></div>
        <div class="signin floatleft">
            <a href="<?php echo site_url($this->appfolder.'/draft')?>"><div class="message"><span><?php echo $this->shipper_info['draft_order_count']?></span></div></a>
            <a href="javascript:;" class="anomaly-a"><div class="set"> <span><?php echo $this->shipper_info['driver_anomaly_count']?></span></div></a>
            <div class="user">
                <span class="username">
                    <p><?php echo $this->shipper_info['shipper_name']?></p>
                    <p>
                        <?php
                        $count_score = '';
                        for ($s = 1; $s <= 5; $s++) {
                            if ($s <= $this->shipper_info['count_score']) {
                                $count_score .= '<img src="'.static_url('static/images/'.$this->appfolder.'/user_star1.png').'">';
                            } else {
                                $count_score .= '<img src="'.static_url('static/images/'.$this->appfolder.'/user_star2.png').'">';
                            }
                        }
                        echo $count_score;
                        ?>
                     </p>
                  </span>
                  <span class="userpic">
                        <img src="<?php echo $this->shipper_info['shipper_head_icon_http_file']?>" width="40" height="40">
                  </span>
                  <span class="usermenu"></span>
            </div>
            <div class="user_nav">
                <ul>
                    <li><a href="<?php echo site_url($this->appfolder.'/member/setting')?>">修改个人资料</a></li>
                    <li><a href="<?php echo site_url($this->appfolder.'/logout')?>">退出登陆</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="nav">
        <ul>
            <li <?php if ($this->router->fetch_class() == 'main') { echo 'class="current"';}?>>
                <a href="<?php echo site_url($this->appfolder.'/main')?>">首页</a>
            </li>
            <li <?php if (in_array($this->router->fetch_class(), array('vehicle', 'calendar'))) { echo 'class="current"';}?>>
                <a href="<?php echo site_url($this->appfolder."/vehicle/vehicle_list/?order_type=997")?>">我的车队</a>
            </li>
            <li <?php if ($this->router->fetch_class() == 'order' && $this->router->fetch_method() == 'publish_order') { echo 'class="current"';}?>>
                <a href="<?php echo site_url($this->appfolder.'/order/publish_order')?>">新建运单</a>
            </li>
            <li <?php if ($this->router->fetch_class() == 'order' && $this->router->fetch_method() == 'wait_get_order') { echo 'class="current"';}?>>   <a href="<?php echo site_url($this->appfolder.'/order/wait_get_order')?>">待接运单</a>
            </li>
            <li <?php if ($this->router->fetch_class() == 'order' && $this->router->fetch_method() == 'wait_order') { echo 'class="current"';}?>>
                <a href="<?php echo site_url($this->appfolder.'/order/wait_order')?>">待运运单</a>
            </li>
            <li <?php if ($this->router->fetch_class() == 'order' && $this->router->fetch_method() == 'carry_order') { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/order/carry_order')?>">在途运单</a></li>
            <li <?php if ($this->router->fetch_class() == 'order' && $this->router->fetch_method() == 'history_order') { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/order/history_order')?>">历史运单</a></li>
            <!-- <li <?php if ($this->router->fetch_class() == 'index') { echo 'class="current"';}?>><a href="<?php echo site_url($this->appfolder.'/statistics')?>">统计报表</a></li> -->
        </ul>
    </div>
</div>

<script type="text/javascript">
$(function () {
    // 查看异常消息
    $('.anomaly-a').click(function() {
        $('.anomaly-div-layer').show();
    });

    // 显示全部异常消息
    $('.anomaly-show-all').click(function() {
        // 设置为已读
        $.post(apppath + 'main/ajax_update_anomaly_view', {}, function(json) {
            if (json.code == 'success') {
                
            } else {
                return false;
            }
        }, 'json');

        $('.anomaly-all-data-html').show();
    });

    // 删除全部异常消息
    $('.anomaly-delete-all').click(function() {
        $('.anomaly-confirm-btn').hide();
        $('.anomaly-delete-all-confirm').show();
    });

    // 确定 删除全部异常消息
    $('.anomaly-delete-all-confirm-ok').click(function() {
        // 设置为已删除
        $.post(apppath + 'main/ajax_update_anomaly_delete', {}, function(json) {
            if (json.code == 'success') {
                window.location.reload();
            } else {
                return false;
            }
        }, 'json');
    });
    // 取消 删除全部异常消息
    $('.anomaly-delete-all-confirm-cancel').click(function() {
        $('.anomaly-confirm-btn').show();
        $('.anomaly-delete-all-confirm').hide();
    });
});
</script>
<!-- 异常消息弹出层 -->
<div class="event_layer anomaly-div-layer">
    <div class="content">
        <div class="close"></div>
        <h2>事件提醒</h2>
        <ul>
            <?php
            if ($driver_anomaly) {
                foreach ($driver_anomaly as $driver_anomaly_value) {
            ?>
            <li>
                <div>
                    <dl>
                        <dt><img src="<?php echo $driver_anomaly_value['driver_data']['driver_head_icon_http_file']?>" width="50" height="50" align="left"></dt>
                        <dd><?php echo '司机 '.$driver_anomaly_value['driver_data']['driver_name'].'，车牌 '.$driver_anomaly_value['vehicle_data']['vehicle_card_num'].'，在 '.$driver_anomaly_value['province_name'].$driver_anomaly_value['city_name'].$driver_anomaly_value['exce_desc'].'。'?></dd>
                    </dl>
                </div>
                <div style="text-align:right;"><?php echo $driver_anomaly_value['cretime']?></div>
            </li>
            <?php
                }
            }
            ?>
        </ul>
    </div>
    <div class="savebut anomaly-confirm-btn">
        <input type="submit" class="cancel anomaly-show-all" value="查看全部">
        <input type="button" class="cancel anomaly-delete-all" value="全部删除">
    </div>
    <div class="confirmdel anomaly-delete-all-confirm">
        <input type="submit" class="confirm anomaly-delete-all-confirm-ok" value="确定">
        <input type="button" class="delcancel anomaly-delete-all-confirm-cancel" value="取消">
    </div>
</div>

<!-- 异常消息弹出层 - 查看全部 -->
<div class="allevent_layer anomaly-all-data-html">
    <div class="content">
        <div class="close"></div>
        <h2>事件提醒</h2>
        <ul>
            <?php
            if ($driver_anomaly) {
                foreach ($driver_anomaly as $driver_anomaly_value) {
            ?>
            <li>
                <div>
                    <dl>
                        <dt>
                            <img src="<?php echo $driver_anomaly_value['driver_data']['driver_head_icon_http_file']?>" width="50" height="50" align="left">
                        </dt>
                        <dd>
                            <?php echo '司机 '.$driver_anomaly_value['driver_data']['driver_name'].'，车牌 '.$driver_anomaly_value['vehicle_data']['vehicle_card_num'].'<br />在 '.$driver_anomaly_value['province_name'].$driver_anomaly_value['city_name'].$driver_anomaly_value['exce_desc'].'。'?>
                        </dd>
                    </dl>
                </div>
                <div style="text-align:right;"><?php echo $driver_anomaly_value['cretime']?></div>
            </li>
            <?php
                }
            }
            ?>
        </ul>
    </div>
</div>