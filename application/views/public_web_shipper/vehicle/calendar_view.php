<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />
<!--[if lte IE 8]>
<script type="text/javascript" src="<?php echo static_url('static/js/excanvas.js')?>"></script>
<![endif]-->

<script type="text/javascript">
function showdriver(i,a){
    var str=" <div class='driverinfo'>" +
    "<p><span>联系方式：</span>12356489787</p>"  +
   " <p><span>当前状态：</span>在途</p>"   +
    "<p><span>货运线路：</span>上海 -- 成都</p>" +
    "<p><span>当前位置：</span>安徽合肥</p>" 
    
    if (a == 1) {   str1= "<p><span>到达时间：</span>预计 04/12  12:00</p>"    +
         "<p><span>调度状态：</span>已指定新运单</p>"+
         " <p class='btn'><input type='button' name='button' value='查看位置' class='cancel'></p>"  
    } else if (a == 2) {  str1= "<p><span>到达时间：</span>预计 04/12  12:00</p>" +
        "<p><span>调度状态：</span>已指定新运单</p>"+
       "<p class='btn'><input type='button' name='button' value='指定运单' class='cancel'><input type='button' name='button' value='查看位置' class='cancel'></p>"  
    } else if (a == 3) {  str1= "<p><span>完成时间：</span>预计 04/12  12:00</p>" +
        "<p><span>等货时间：</span>32小时20分钟</p>"+
        "<p><span>调度状态：</span>已指定新运单</p>"+
        "<p class='btn'><input type='button' name='button' value='指定运单' class='cancel'><input type='button' name='button' value='查看位置' class='cancel'></p>" 
    }
    str2= " </div>"
    driverinfo=str+str1+str2;
    $(".driverinfo").remove();
   
    $(".driver").css("background","#fbfbfb");
    $(i).before(driverinfo);
    offset = $(i).offset();
    offsettop = offset.top;
    if (offsettop>400){
        $(i).prev(".driverinfo").css("top","-300px");
    }
    $(i).parent(".driver").css("background","#e4e4e4")
    a="";
}
$(function() {
    $("#calendar .startdate").each(function(){
        $(this).mouseover(function(){
            $(this).prev(".pop").show();
        });
        $(this).mouseout(function(){
            $(this).prev(".pop").hide();
        });
    });

    $("#calendar .enddate").each(function(){
            $(this).mouseover(function(){
            $(this).prev(".endpop").show();
        });
            $(this).mouseout(function(){
            $(this).prev(".endpop").hide();
        });
    });
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="mask" style="display:none"></div>

<div class="container" >
    <div class="fleet">
       <h1>
            <span class="f_title">日历调度表</span>
            <span class="f_data"> 4月26 - 5月2日</span>
            <span class="f_back"> <a href="<?php echo site_url($this->appfolder.'/vehicle')?>" class="current">退出</a> </span>
       </h1>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="calendar">
            <tr class="title">
                <td>司机信息</td>
                <td>周一 04-26</td>
                <td>周二 04-27</td>
                <td>周三 04-28</td>
                <td>周四 04-29</td>
                <td>周五 04-30</td>
                <td>周六 05-01</td>
                <td>周日 05-02</td>
            </tr>
            <tr>
                <td class="driver">
                    <img src="<?php echo static_url('static/images/'.$this->appfolder.'/re.jpg')?>" width=40 height=40 align=left onclick="showdriver(this,1)"> 王刚<br>皖ABCD
                </td>
                <td>&nbsp;</td>
                <td>
                    <div class='pop'>
                        <div class='arr_box'>
                            发车时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="startdate"></span>
                    <span class="company">上海创协物流公司</span>
                    <span class="rate_a green"></span>&nbsp;
                </td>
                <td><span class="rate_b green"></span>&nbsp;</td>
                <td>
                    <div class='endpop'>
                        <div class='arr_box'>
                            到达时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="enddate"></span>
                    <span class="companyb">成都创协物流公司</span>
                    <span class="rate_c green"></span>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="driver">
                    <img src="<?php echo static_url('static/images/'.$this->appfolder.'/rw.jpg')?>" width=40 height=40 align=left onclick="showdriver(this,2)"> 张云<br>皖ABCD
                </td>
                <td>&nbsp;</td>
                <td>
                    <div class='pop'>
                        <div class='arr_box'>
                            发车时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="startdate"></span>
                    <span class="company">上海创协物流公司</span>
                    <span class="rate_a blue"></span>
                </td>
                <td>
                    <div class='endpop'>
                        <div class='arr_box'>
                            到达时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="enddate"></span>
                    <span class="companyb">成都创协物流公司</span>
                    <span class="rate_c blue"></span>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="driver">
                    <img src="<?php echo static_url('static/images/'.$this->appfolder.'/re.jpg')?>" width=40 height=40 align=left onclick="showdriver(this,3)"> 王刚<br>皖ABCD
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <div class='pop'>
                        <div class='arr_box'>
                            发车时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="startdate"></span>
                    <span class="company">上海创协物流公司</span>
                    <span class="rate_a blue"></span>
                </td>
                <td><span class="rate_b blue"></span>&nbsp;</td>
                <td>
                    <div class='endpop'>
                        <div class='arr_box'>
                            到达时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="enddate"></span>
                    <span class="companyb">成都创协物流公司</span>
                    <span class="rate_c blue"></span>
                </td> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="driver">
                    <img src="<?php echo static_url('static/images/'.$this->appfolder.'/rw1.gif')?>" width=40 height=40 align=left onclick="showdriver(this,3)"> 王刚<br>皖ABCD
                </td>
                <td><span class="empty">空车</span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="driver">
                    <img src="<?php echo static_url('static/images/'.$this->appfolder.'/rw.jpg')?>" width=40 height=40 align=left onclick="showdriver(this,3)"> 张云<br>皖ABCD
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <div class='pop'>
                        <div class='arr_box'>
                            发车时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="startdate"></span>
                    <span class="company">上海创协物流公司</span>
                    <span class="rate_a blue"></span>
                </td>
                <td><span class="rate_b blue"></span>&nbsp;</td>
                <td><span class="rate_b blue"></span>&nbsp;</td>
                <td>
                    <div class='endpop'>
                        <div class='arr_box'>
                            到达时间
                            <br>
                            预计 04/20 12:00
                        </div>
                    </div>
                    <span class="enddate"></span>
                    <span class="companyb">成都创协物流公司</span>
                    <span class="rate_c blue"></span>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="driver">
                    <img src="<?php echo static_url('static/images/'.$this->appfolder.'/rw1.gif')?>" width=40 height=40 align=left onclick="showdriver(this,3)"> 王刚<br>皖ABCD
                </td>
                <td></td>
                <td>&nbsp;</td>
                <td><span class="empty">空车</span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</div>
</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>