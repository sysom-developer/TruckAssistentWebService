<script type="text/javascript">
$(function () {
    // 运单跟踪
    $('.order-tracking-btn').click(function() {
        $('.order-detail-layer').hide();
        $('.order-tracking-layer').show();
    });
});
</script>

<!--运单跟踪详情开始-->
<div class="order_detail order-tracking-layer" style="display:none">
     <div class="close"></div>
     <div class="ordernum track-order-num"></div>
     <div class="order_staic">
        <div class="line"></div>
        <ul id="track_st_html">
            <li id="track_st_1"><span style="background: #ccc;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/step1.png')?>"></span><p>接单</p></li>
            <li id="track_st_2"><span style="background: #ccc;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/step2.png')?>"></span><p>装货</p></li>
            <li id="track_st_3"><span style="background: #ccc;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/step3.png')?>"></span><p>运输中</p></li>
            <li id="track_st_4"><span style="background: #ccc;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/step4.png')?>"></span><p>卸货</p></li>
            <li id="track_st_5"><span style="background: #ccc;"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/step5.png')?>"></span><p>完成</p></li>
        </ul>
    </div>
    <div class="order_process">
        <ul id="track_desc_html">
            <!-- <li>
                <span class="radius"></span>
                <span class="cn">
                    <p>已给运单车司机评价</p>
                    <p>
                        <img src="<?php echo static_url('static/images/'.$this->appfolder.'/pd1.jpg')?>">
                        <img src="<?php echo static_url('static/images/'.$this->appfolder.'/pd1.jpg')?>">
                        <img src="<?php echo static_url('static/images/'.$this->appfolder.'/pd1.jpg')?>">
                    </p>
                </span>
                <span class="data">2015-4-20 18:00</span>
            </li>
            <li>
                <span class="radius"></span>
                <span class="cn">已给运单车司机评价</span>
                <span class="data">2015-4-20 18:00</span>
            </li> -->
        </ul>
    </div>
</div>
<!--运单跟踪详情结束-->