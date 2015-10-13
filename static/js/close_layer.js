$(function() {
    // 关闭所有弹出层
    $('.close').click(function(){
        $('.order_detail').hide();
        $('.editcar').hide();
        $('.map').hide();
        $('.order-edit-layer').hide();
        $('.order-edit-layer-btn').hide();
        $('.order-detail-layer').hide();
        $('.order-detail-layer-btn').hide();
        $('.order-tracking-layer').hide();
        $('.order-contract-layer').hide();
        $('.anomaly-div-layer').hide();
        $('.anomaly-all-data-html').hide();
        $('.driver-avg-count-layer').hide();
        $('.send-vehicle-message-layer').hide();
        $('.orderedit').hide();

        $('.editorcontent').hide();
        $('.mask').hide();

        $('.head').removeClass('fixed');
        $('.container').removeClass('serachfixed');
    });
});