<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<script type="text/javascript">
var order_id = 0;
$(function() {
    window.placeholder();

    // 运单确认
    $('.history-order-confirm').click(function() {
        $(".mask").show();
        order_id = $(this).attr('order_id');
        $(".hisotry-confirm-order-layer").show();
    });

    // 运单确认 确认 弹出评价层
    $('.history-confirm-order-ok').click(function() {
        $.post(apppath + 'order/ajax_confirm_order', {order_id: order_id}, function(json) {
            if (json.code == 'success') {
                $(".mask").show();
                $(".hisotry-confirm-order-layer").hide();
                $(".editorcontent").show();
                $(".history-order-comment-layer").show();
                $('.history-order-comment-text-html > ul > li').show();

                $(".head").addClass("fixed");
                $(".container").addClass("serachfixed");
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });

    // 弹出评价层
    $('.history-order-comment').click(function() {
        order_id = $(this).attr('order_id');

        $(".mask").show();
        $(".hisotry-confirm-order-layer").hide();
        $(".editorcontent").show();
        $(".history-order-comment-layer").show();
        $('.history-order-comment-text-html > ul > li').show();

        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });

    // 确认评价
    $('.comment-confirm-submit').click(function() {
        $(this).attr('disabled', true);
        $("input[name=order_id]").val(order_id);

        $.post(apppath + 'order/ajax_comment_order', $('form[name=comment_form]').serialize(), function(json) {
            if (json.code == 'success') {
                window.location.reload();
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });

    // 运单确认 取消
    $('.history-confirm-order-cancel').click(function() {
        $(".mask").hide();
        $(".hisotry-confirm-order-layer").hide();
    });

    // 评价选择星
    var star1_url = '<?php echo static_url("static/images/'+appfolder+'/star1.png")?>';
    var star2_url = '<?php echo static_url("static/images/'+appfolder+'/star2.png")?>';
    $('.history-order-comment-star').click(function() {
        var index = $('.history-order-comment-star').index(this);

        if (index == 0) {
            if ($(this).attr('src') == star1_url) {
                $('.history-order-comment-star').attr('src', star2_url);
                $(this).attr('src', star2_url);
                $(this).prev("input[name='comment_star[]']").attr("checked", false);
            } else {
                $(this).attr('src', star1_url);
                $(this).prev("input[name='comment_star[]']").attr("checked", true);
            }
        } else {
            $('.history-order-comment-star').each(function(item) {
                if (item <= index) {
                    $(this).attr('src', star1_url);
                    $(this).prev("input[name='comment_star[]']").attr("checked", true);
                } else {
                    $(this).attr('src', star2_url);
                    $(this).prev("input[name='comment_star[]']").attr("checked", false);
                }
            });
        }
    });

    // 评价选择文字
    $('.history-order-comment-text-html > ul > li').click(function() {
        if ($(this).attr('class') == 'current') {
            $(this).removeClass("current");
            $(this).find("input[name='comment_text[]']").attr("checked", false);
        } else {
            $(this).addClass("current");
            $(this).find("input[name='comment_text[]']").attr("checked", true);
        }
    });
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="editorcontent" style="display:none">
    <?php $this->load->view($this->appfolder.'/order/detail_order_view')?>

    <?php $this->load->view($this->appfolder.'/order/history_order_driver_route_map_view')?>

    <!--评价开始-->
    <form name="comment_form" method="post" action="">
    <input type="hidden" name="order_id">
    <div class="comment history-order-comment-layer" style="display:none">
        <div class="errormessage loca" style="display: none;"><span>请选择评价理由.....</span></div>
        <div class="close"></div>
        <div class="star">
            <h2>请给货运司机评价</h2>
            <span>
                <input type="checkbox" name="comment_star[]" value="1" style="display: none;">
                <img class="history-order-comment-star" src="<?php echo static_url('static/images/'.$this->appfolder.'/star2.png')?>">
            </span>
            <span>
                <input type="checkbox" name="comment_star[]" value="2" style="display: none;">
                <img class="history-order-comment-star" src="<?php echo static_url('static/images/'.$this->appfolder.'/star2.png')?>">
            </span>
            <span>
                <input type="checkbox" name="comment_star[]" value="3" style="display: none;">
                <img class="history-order-comment-star" src="<?php echo static_url('static/images/'.$this->appfolder.'/star2.png')?>">
            </span>
            <span>
                <input type="checkbox" name="comment_star[]" value="4" style="display: none;">
                <img class="history-order-comment-star" src="<?php echo static_url('static/images/'.$this->appfolder.'/star2.png')?>">
            </span>
            <span>
                <input type="checkbox" name="comment_star[]" value="5" style="display: none;">
                <img class="history-order-comment-star" src="<?php echo static_url('static/images/'.$this->appfolder.'/star2.png')?>">
            </span>
        </div>
        <div class="com history-order-comment-text-html">
            <h2>请选择评价理由</h2>
            <ul>
                <li><input type="checkbox" name="comment_text[]" value="爱护货物" style="display: none;">爱护货物</li>
                <li><input type="checkbox" name="comment_text[]" value="准点守时" style="display: none;">准点守时</li>
                <li><input type="checkbox" name="comment_text[]" value="专业" style="display: none;">专业</li>
                <li><input type="checkbox" name="comment_text[]" value="负责任" style="display: none;">负责任</li>
                <li><input type="checkbox" name="comment_text[]" value="讲信用" style="display: none;">讲信用</li>
                <li><input type="checkbox" name="comment_text[]" value="装货守时" style="display: none;">装货守时</li>
                <li><input type="checkbox" name="comment_text[]" value="沟通及时" style="display: none;">沟通及时</li>
                <li><input type="checkbox" name="comment_text[]" value="送货守时" style="display: none;">送货守时</li>
                <li><input type="checkbox" name="comment_text[]" value="服务好" style="display: none;">服务好</li>
                <li><input type="checkbox" name="comment_text[]" value="卸货守时" style="display: none;">卸货守时</li>
                <li><input type="checkbox" name="comment_text[]" value="服务一般" style="display: none;">服务一般</li>
                <li><input type="checkbox" name="comment_text[]" value="货物损坏" style="display: none;">货物损坏</li>
            </ul>
            <div><input type="button" class="delcancel comment-confirm-submit" value="确定" style="cursor: pointer;"/></div>
        </div>
    </div>
    </form>
    <!--评价结束-->
</div>

<div class="mask" style="display:none;"></div>

<!--确认运单开始-->
<div class="ordercomfirm hisotry-confirm-order-layer">
    <p style="height:80px;line-height:100px;">确认运单已成功运送到卸货地点！</p>
    <p style="border-top:1px solid #e7e7e7;text-align:center;padding:10px 20px;">
        <input type="button" class="confirm history-confirm-order-ok" style='cursor: pointer;' value="确定">
        <input type="button" class="delcancel history-confirm-order-cancel" style='cursor: pointer;' value="取消">
    </p>
</div>
<!--确认运单结束-->

<div class="container" >
    
    <?php $this->load->view($this->appfolder.'/order/history_order_top_view')?>

    <div class="order historyorder">
        <ul class="white listtitle"> 
            <li>运单编号</li> 
            <li>司机姓名</li> 
            <li>联系方式</li> 
            <li>车牌号码</li> 
            <!-- <li>车辆信息</li> --> 
            <li>出发地 </li> 
            <li>目的地</li> 
            <li class="px">
                发车时间
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
            <li>到达时间</li> 
            <li>完成时间</li> 
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

                $handle = '-';
                if ($data['is_comment'] == 2) {
                    $handle = '<a order_id="'.$data['order_id'].'" class="com_x history-order-comment" href="javascript:;">评价</a></li>';
                }
                if ($data['is_finished'] == 2) {
                    $handle = '<a order_id="'.$data['order_id'].'" class="com_w history-order-confirm" href="javascript:;">运单确认</a>';
                }
        ?>
        <ul class="<?php echo $ul_class?>">
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><a href="javascript:;"><?php echo $data['order_num']?></a></span></li> 
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_name']?></span></li> 
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['driver_data']['driver_mobile']?></span></li>
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['vehicle_data']['vehicle_card_num']?></span></li> 
            <!-- <li class="show-order-detail" order_id="<?php echo $data['order_id']?>"><?php echo $data['vehicle_type_data']['type_name'].$data['vehicle_data']['vehicle_length']?>米</li> -->
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_start_city']?></span></li>
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo $data['order_end_city']?></span></li>
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo date('m-d H:i', $data['good_start_time'])?></span></li> 
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo date('m-d H:i', $data['good_end_time'])?></span></li> 
            <li class="show-order-detail" style="display:table;height:60px;table-layout:fixed; word-break:break-all; word-wrap:break-word"order_id="<?php echo $data['order_id']?>"><span style="display:table-cell;vertical-align: middle;"><?php echo date('m-d H:i', $data['order_end_time'])?></span></li>
            <li>
                <?php echo $handle?>
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