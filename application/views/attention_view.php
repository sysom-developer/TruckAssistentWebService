<?php $this->load->view('header_view');?>

<link href="<?php echo static_url('static/css/homepage.css')?>" rel="stylesheet" type="text/css"/>    
<link href="<?php echo static_url('static/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo static_url('static/js/jquery-2.1.4.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/bootstrap.min.js');?>" type="text/javascript"></script>

<body>

<?php $this->load->view('top_menu_view');?>
                                    
<div class="item">
    <img src="<?php echo static_url('static/images/attention.png')?>" alt="" style="width: 100%;height: 400px;">                     
        <div class="attention_qr">
            <img src="<?php echo static_url('static/images/public.jpg')?>" /> 
            <p>途好运货老板微信公众号</p>
        </div><!--attention_qr-->
</div><!--item-->               

<div class="attention_text">
    <div class="text_one">
        <h1>关于我们</h1>
        <p>上海麦速物联网信息科技有限公司成立于2014年，由国内最早一批从事车联网解决方案的团队和物流专业人士组成。
聚焦通过互联网模式和车联网技术，整合个体货运车主资源，为车主提供专业化的调度、运营、在线支付、保险、购车、
团购、售后服务等为专线、第三方物流企业和货主等提供统一形象、信用担保、成本更低和更有保障的透明车队运输服务
同时也涉及专线、第三方物流企业、货主等内部供应链信息系统建设和服务。
        </p>
    </div>
    <div class="text_two">
        <h1>我们的使命</h1>
        <p>为货老板管车&nbsp;&nbsp;&nbsp;&nbsp;为车老板配货。</p>
    </div>
    <div class="text_tree">
        <h1>联系我们</h1>
        <p>上海市徐汇区钦州路100号上海市科技创业中心1号楼607室 
        <br/>
        客服电话：021-61358385&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客服邮箱：service@thy56.com
        <br/>
        传真：021-61358386&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客服QQ群：2086191419 途好运客服
        </p>
    </div>
</div><!--attention_text-->

<div class="attention_bottom">
    <p>copyright@2015 上海麦速物联网信息科技有限公司  沪ICP备15022775号-2</p>
</div>

</body>

<?php $this->load->view('footer_view');?>