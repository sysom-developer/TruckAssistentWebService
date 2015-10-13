<script type="text/javascript">
$(function() {
    $('.driver-avg-count-li').click(function() {
        var driver_id = $(this).attr('driver_id');
        var driver_name = $(this).attr('driver_name');

        $('.driver-avg-count-loading').show();
        $('.driver-avg-count-driver-name').html(driver_name);

        // 获取运单详情
        $.post(apppath + 'main/ajax_get_driver_avg_count', {driver_id: driver_id}, function(json) {
            if (json.code == 'success') {
                if (json.data_list.length != undefined) {
                    for (var i = 0; i < json.data_list.length; i++) {
                        var j = i + 1;

                        $('td[name=driver_avg_go_to_'+j+']').html('总发车次数：'+json.data_list[i].go_to+'，平均发车次数：'+json.data_list[i].avg_go_to+'');
                        $('td[name=driver_avg_freight_'+j+']').html('总收入：'+json.data_list[i].freight+'，平均月收入：'+json.data_list[i].avg_freight+'');
                    };
                }

                $('.driver-avg-count-loading').hide();
            } else {
                return false;
            }
        }, 'json');

        $('.driver-avg-count-layer, .driver-avg-count-html').show();

        $(".mask").show();
        $(".editorcontent").show();
        
        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });
});
</script>

<div class="order_detail driver-avg-count-layer" style="display: none;">
    <div class="close"></div>

    <div class='driver-avg-count-loading' style="text-align: center; display: none;">
        <span class="good-load-addr-loading"><img src="<?php echo static_url('static/images/loading.gif')?>">
    </div>
    <div class="pdinfo driver-avg-count-html" style="display:none;">
        <h2 class="driver-avg-count-driver-name">货物信息</h2>
        <div>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="100">一月：</td>
                    <td name="driver_avg_go_to_1"></td>
                    <td name="driver_avg_freight_1"></td>
                </tr>
                <tr>
                    <td>二月：</td>
                    <td name="driver_avg_go_to_2"></td>
                    <td name="driver_avg_freight_2"></td>
                </tr>
                <tr>
                    <td>三月：</td>
                    <td name="driver_avg_go_to_3"></td>
                    <td name="driver_avg_freight_3"></td>
                </tr>
                <tr>
                    <td>四月：</td>
                    <td name="driver_avg_go_to_4"></td>
                    <td name="driver_avg_freight_4"></td>
                </tr>
                <tr>
                    <td>五月：</td>
                    <td name="driver_avg_go_to_5"></td>
                    <td name="driver_avg_freight_5"></td>
                </tr>
                <tr>
                    <td>六月：</td>
                    <td name="driver_avg_go_to_6"></td>
                    <td name="driver_avg_freight_6"></td>
                </tr>
                <tr>
                    <td>七月：</td>
                    <td name="driver_avg_go_to_7"></td>
                    <td name="driver_avg_freight_7"></td>
                </tr>
                <tr>
                    <td>八月：</td>
                    <td name="driver_avg_go_to_8"></td>
                    <td name="driver_avg_freight_8"></td>
                </tr>
                <tr>
                    <td>九月：</td>
                    <td name="driver_avg_go_to_9"></td>
                    <td name="driver_avg_freight_9"></td>
                </tr>
                <tr>
                    <td>十月：</td>
                    <td name="driver_avg_go_to_10"></td>
                    <td name="driver_avg_freight_10"></td>
                </tr>
                <tr>
                    <td>十一月：</td>
                    <td name="driver_avg_go_to_11"></td>
                    <td name="driver_avg_freight_11"></td>
                </tr>
                <tr>
                    <td>十二月：</td>
                    <td name="driver_avg_go_to_12"></td>
                    <td name="driver_avg_freight_12"></td>
                </tr>
            </table>
        </div>
    </div>
</div>