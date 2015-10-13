<script type="text/javascript">
var driver_id = '';
$(function() {
    $(".send-vehicle-message-btn").click(function() {
        driver_id = $(this).attr('driver_id');

        $(".send-vehicle-message-layer").show();

        $(".mask").show();
        $(".editorcontent").show();
        
        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });

    // 确定发送
    $('.send-vehicle-message-ok-btn').click(function() {
        var _this = $(this);
        $(this).attr('disabled', true);

        var content = $('textarea[name=content]').val();

        $.post(apppath + 'vehicle/ajax_send_vehicle_message', {driver_id: driver_id, content: content}, function(json) {
            _this.attr('disabled', false);
            if (json.code == 'success') {
                $('textarea[name=content]').val('');
                alert('发送成功');
                $('.close').trigger('click');
            } else {
                return false;
            }
        }, 'json');
    });

    // 取消
    $('.send-vehicle-message-cancel-btn').click(function() {
        $('.close').trigger('click');
    });
});
</script>

<div class="send_vehicle_message send-vehicle-message-layer" style="display:none;">
    <div class="close"></div>
    <div>
        <dl>
            <dt>
                <textarea name="content"></textarea>
            </dt>
        </dl>
    </div>
    <div class="btn_layer">
        <input type="button" class="send-vehicle-message-ok-btn" value="确定发送">
        <input type="button" class="send-vehicle-message-cancel-btn" value="取 消">
    </div>
</div>