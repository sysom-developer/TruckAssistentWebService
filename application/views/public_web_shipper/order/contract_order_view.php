<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>运输合同</title>
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.js')?>"></script>
<style>
body {
    margin: 0em 3em 0em 3em;
    padding: 0;
    border: 0;
    color: black;
    background: white;
    font: normal 10pt "Bakersville Old Face", "Times New Roman", Times, serif;
    text-align: left;
}
.print{width:100%;text-align:center;margin-top:50px;margin-bottom:40px;}
.print a{margin-right:40px;padding:3px 10px;border:1px solid #e7e7e7;}
</style>
<script type="text/javascript">
$(function() {
    $("#print").click(function(){
        $(".print").css('display','none');
        window.print();
    });
});
</script>
</head>

<body>
<div class="yspact">
    <p style="text-align:center !important;font-size:18px;"><strong>运输合同</strong><strong> </strong></p>
    <p><strong>&nbsp;</strong></p>
    <p>甲方 :  <span name="shipper_company_name"><?php echo $contract_data['shipper_company_name']?></span>  <span style="float:right;color:red;">   合同编号：<span name="order_num"><?php echo $contract_data['order_num']?></span></span> </p>
    <p>乙方 :&nbsp;&nbsp;<span name="driver_name"><?php echo $contract_data['driver_name']?></span></p>
    <p>丙方：上海麦速物联网信息科技有限公司</p>

    <p>根据《中华人民共和国合同法》等有关法律规定，经过双方充分协商，特订立本合同，以便双方共同遵守。 </p>
    <p>丙方的责任： <br />
      丙方使用途好运产品，提供本份运输合同的电子版给甲方与乙方确认． </p>
    <p>&nbsp;</p>
    <p>乙方的责任： </p>
    <p>一、乙方为甲方运输货物（名称）：百货，数量 : 30（件、包箱），体积：80立方米 </p>
    <p>全程运费22500元，发车前甲方预付10000元，货到付10000元，货物经货主验收合格后凭回单到上海付2500元。 </p>
    <p>补充协议：货物超重或者货物体积超限，补贴金额甲乙双方协商解决。 </p>
    <p>二、交货地址：成都市金牛区天回镇冠川汽配城A4号1-7大库 </p>
    <p>收货人：孙经理            电话 ：18756489213 </p>
    <p>三、在承运过程中，货物如被油污、磨损、雨淋、丢失及由肇事、火灾等引起的一切 <br />
      损失，均由乙方负责全额赔偿。 </p>
    <p>四、运输时间：从<?php echo date('Y年m月m日', $order_data['good_start_time'])?> 至 <?php echo date('Y年m月m日', $order_data['good_end_time'])?>，如不能按时到达交货地点，每迟到一天扣乙方百分之十的运费，以此递增；如有特殊情况不能及时到达目的地，应电话通知甲方；如百般挑剔，拒绝卸车，给甲方造成的一切损失，均由乙方负责赔偿。 </p>
    <p>五、运输途中甲方无押车人员，乙方应清点货物数量，并在货物清单上签字，司机出上海之前必须过磅，如不过磅路上产生一切费用与本公司无关。货到目的地验收合格，由货主签收回单，需回单结算的应在一个月之内交给甲方，否则不予结算余款。 </p>
    <p>甲方的责任：甲方负责为乙方提供货物的相关手续，备沿途检查。 <br />
      合同经双方同意生效，具有法律效力 </p>
    <p>此合同电子版包括但不限于图片、pdf文档、扫描件等，具备与纸质合同相同的法律效力。 </p>
    <p>
        车牌号：<span name="vehicle_card_num"><?php echo $contract_data['vehicle_card_num']?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        发动机号：<span name="vehicle_engine"><?php echo $contract_data['vehicle_engine']?></span>
        <br />
        驾驶员姓名：<span name="driver_name"><?php echo $contract_data['driver_name']?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        电话：<span name="driver_mobile"><?php echo $contract_data['driver_mobile']?></span>
    </p>
    <p>
        驾驶证号码：&nbsp;<span name="driver_license"><?php echo $contract_data['driver_license']?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;身份证号码：<span name="driver_card_num"><?php echo $contract_data['driver_card_num']?></span>
    </p>
    <p>&nbsp;</p>
    <p>甲方：<span name="shipper_name"><?php echo $contract_data['shipper_name']?></span></p>
    <p>
        地址：<span name="shipper_company_addr"><?php echo $contract_data['shipper_company_addr']?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        邮编：<span name="zipcode"><?php echo $contract_data['zipcode']?></span>
    </p>
    <p>电话：<span name="shipper_phone"><?php echo $contract_data['shipper_phone']?></span></p>
    <p>传真：<span name="shipper_fax"><?php echo $contract_data['shipper_fax']?></span></p>

    <p>&nbsp;</p>
    <p>乙方：<span name="driver_name"><?php echo $contract_data['driver_name']?></span></p>
    <p> <span style="float:right;color:red;">执行日期：<span name="good_start_time"><?php echo $contract_data['good_start_time']?></span></span></p>
</div>
<div class="print">
    <p>
        <a href="javascript:;" id="print">打印</a>
        <!-- <a href="javascript:;">保存到本地</a> -->
    </p>
</div>
</body>
</html>