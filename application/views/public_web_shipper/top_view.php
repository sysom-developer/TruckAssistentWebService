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
            <a href="javascript:;" class="anomaly-a driver-anomaly-btn"><div class="set driver-anomaly-not-read-count"> <span><?php echo $this->shipper_info['driver_anomaly_count']?></span></div></a>
            <div class="user">
                <span class="username">
                    <p><?php echo $this->shipper_info['shipper_name']?></p>
                    <!--<p>
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
                     </p>-->
                  </span>
                  <span class="userpic">
                        <img src="<?php echo $this->shipper_info['shipper_head_icon_http_file']?>" width="40" height="40">
                  </span>
                  <span class="usermenu"></span>
            </div>
            <div class="user_nav">
                <ul>
                    <li><a href="<?php echo site_url($this->appfolder.'/member/member_publish')?>">添加员工</a></li>
                    <li><a href="<?php echo site_url($this->appfolder.'/member/setting')?>">修改个人资料</a></li>
                    <li><a href="<?php echo site_url($this->appfolder.'/member/my_score')?>">我的积分</a></li>
                    <li><a href="<?php echo site_url($this->appfolder.'/member/my_qrcode')?>">我的二维码</a></li>
                    <li><a href="<?php echo site_url($this->appfolder.'/logout')?>">退出登陆</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function () {
    // 查看异常消息
    $('.driver-anomaly-btn').click(function() {
        var display_status = $('.anomaly-div-layer').css("display");

        if (display_status == 'none') {
            $('.anomaly-div-layer').show();
            // 获取异常数据
            $.post(apppath + 'main/ajax_get_driver_anomaly', {}, function(json) {
                if (json.code == 'success') {
                    $('.driver-anomaly-first-data-list').html(json.driver_anomaly_html);
                    $('.driver-anomaly-second-data-list').html(json.driver_anomaly_html);
                }
            }, 'json');
        } else if (display_status == 'block') {
            $('.anomaly-div-layer').hide();
        }
    });

    // 显示全部异常消息
    $('.anomaly-show-all').click(function() {
        // 设置为已读
        $.post(apppath + 'main/ajax_update_anomaly_view', {}, function(json) {
            if (json.code == 'success') {
                $('.driver-anomaly-not-read-count').find('span').html(0);
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

    // 定时请求异常数据
    window.setInterval(function() {
        push_driver_anomaly();
    }, 60000);

    function push_driver_anomaly() 
    {
        // 获取异常数据
        $.post(apppath + 'main/ajax_get_driver_anomaly', {is_interval: 1}, function(json) {
            if (json.code == 'success') {
                $('.driver-anomaly-not-read-count').find('span').html(json.driver_anomaly_count);

                $('.driver-anomaly-first-data-list').html(json.driver_anomaly_html);
                $('.driver-anomaly-second-data-list').html(json.driver_anomaly_html);
            }
        }, 'json');
    }
});
</script>
<!-- 异常消息弹出层 -->
<div class="event_layer anomaly-div-layer">
    <div class="content">
        <div class="close"></div>
        <h2>事件提醒</h2>
        <ul class="driver-anomaly-first-data-list">
            
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
        <ul class="driver-anomaly-second-data-list">
           
        </ul>
    </div>
</div>