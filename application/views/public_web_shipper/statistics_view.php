<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/style.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo static_url('static/css/'.$this->appfolder.'/indexs.css')?>" />

<script type="text/javascript" src="<?php echo static_url('static/js/Chart1.js')?>"></script>

<script type="text/javascript">
$(function() {
    
    $("#tabnav1").click(function(){
        $(this).addClass("carcount");
        $("#tabnav2").removeClass("moneycount");
    });
    $("#tabnav2").click(function(){
        $(this).addClass("moneycount");
        $("#tabnav1").removeClass("carcount");
    });
    $(".week div").each(function(){
         $(this).click(function(){
             $(".week div").removeClass("current");
             $(this).addClass("current");
         });
    });
});
</script>

<body>

<?php $this->load->view($this->appfolder.'/top_view')?>

<div class="countchat">
    <div class="tabmenu">
        <a class="carcount" id="tabnav1"> 运单发车统</a>
        <a  id="tabnav2" > 运单金额统计</a>
            <DIV class="w86select w85" >
                         <SELECT  style="display:none" name="select2" id="select1">
                             <OPTION value=1>全部</OPTION>
                             <OPTION value=2>货物类型</OPTION>
                         </SELECT>
             </DIV>
    
    </div>
    <div class="countpiclist">
          <div class="condition">
            <span class="leftbutton">总发车：<font style="color:#f36315">1250次</font> &nbsp;&nbsp;&nbsp;&nbsp;本周发车：<font style="color:#f36315">240次</font></span>
            <span class="data">
                    <div id="left_a"  onclick="move_left();"><</div>
                     <div id="datadiv">
                         <div id="ullwidtha">
                            <ul>
                             <li>4月20号 - 4月26号</li>
                             <li>4月27号 - 5月3号</li>
                             <li>5月4号 - 5月10号</li>
                             <li>5月11号 - 5月17号</li>
                            </ul>
                         </div>
                     </div>
                    <div id="right_a" onclick="move_right();">></div>
            </span>
            <span class="week">
              <div id="month">月</div> <div class="current" id="day">周</div>
            </span>
       </div>
         <div class="grida">
            
            <div class="countinfo">
                <canvas id="canvas" height="140" width="600" style="display:block;"></canvas>
            </div>
        </div>
        

    <script>
        //var randomScalingFactor = function(){ return Math.round(Math.random()*10)};
        var lineChartData = {
            labels : ["周一","周二","周三","周四","周五","周六","周日"],
            datasets : [
                
                {
                    label: "My Second dataset",
                    fillColor : "rgba(254,120,47,0.2)",
                    strokeColor : "rgba(254,120,47,1)",
                    pointColor : "rgba(255,255,255,1)",
                    pointStrokeColor : "#fe782f",
                    pointHighlightFill : "#fe782f",
                    pointHighlightStroke : "rgba(255,172,82,1)",
                    data : ["20","15","20","5","10","5","10"]
                }
            ]

        }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
        
    
    }


    </script> 
    </div>
  
</div>

<div class="container" >
    <div class="serach">
        <div class="serach_select">
            <select class="search-select" name="search_type">
                <option value="create_time">创建时间</option>
                <option value="good_category">货物类型</option>
            </select>
        </div>
        
        <div class="serach_blank">
            <form name="search_form" action="<?php echo site_url($this->appfolder.'/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/')?>" method="get">
            <span>
                <input name="k" type="text" val="请输入搜索内容" value="<?php echo !empty($k) ? $k : '请输入搜索内容'?>" class="so placeholder">
                <input name="submit" type="submit" value="" class="serachin"/>
            </span>
            </form>
        </div>
    </div>

    <div class="countlist">
            <ul class="white"> 
                <li>司机姓名</li> 
                <li>联系方式</li> 
                <li>车牌号码</li> 
                <li>车辆信息</li> 
                <li>常跑路线</li> 
                <li>总发车数量</li> 
                <li>本月发车</li> 
                <li>支付总金额</li> 
               <li>本月支付</li> 
                <li>货主评价</li> 
           </ul>
            <ul class="hui">
                <li><a href="">王实甫</a></li> 
                <li>12343567885</li> 
                <li>皖A2389</li> 
                <li>平析17.5米</li> 
                <li>上海 - 成都</li> 
                <li>300</li> 
                <li>12</li> 
                <li>30000000</li> 
                <li>120000</li> 
                <li><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star2.png')?>"></li> 
            </ul> 
             <ul class="white">
                <li><a href="">王实甫</a></li> 
                <li>12343567885</li> 
                <li>皖A2389</li> 
                <li>平析17.5米</li> 
                <li>上海 - 成都</li> 
                <li>300</li> 
                <li>12</li> 
                <li>30000000</li> 
                <li>120000</li> 
                <li><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star2.png')?>"></li> 
            </ul> 
             <ul class="hui">
                <li><a href="">王实甫</a></li> 
                <li>12343567885</li> 
                <li>皖A2389</li> 
                <li>平析17.5米</li> 
                <li>上海 - 成都</li> 
                <li>300</li> 
                <li>12</li> 
                <li>30000000</li> 
                <li>120000</li> 
                <li><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star2.png')?>"></li> 
            </ul> 
             <ul class="white">
                <li><a href="">王实甫</a></li> 
                <li>12343567885</li> 
                <li>皖A2389</li> 
                <li>平析17.5米</li> 
                <li>上海 - 成都</li> 
                <li>300</li> 
                <li>12</li> 
                <li>30000000</li> 
                <li>120000</li> 
                <li><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star2.png')?>"></li> 
            </ul> 
             <ul class="hui">
                <li><a href="">王实甫</a></li> 
                <li>12343567885</li> 
                <li>皖A2389</li> 
                <li>平析17.5米</li> 
                <li>上海 - 成都</li> 
                <li>300</li> 
                <li>12</li> 
                <li>30000000</li> 
                <li>120000</li> 
                <li><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star1.png')?>"><img src="<?php echo static_url('static/images/'.$this->appfolder.'/user_star2.png')?>"></li> 
            </ul> 
             
</div> 
   <div class="page"><a href=""><img src="<?php echo static_url('static/images/'.$this->appfolder.'/prev.gif')?>"></a><a href="" ><img src="<?php echo static_url('static/images/'.$this->appfolder.'/preva.gif')?>"></a><a href="" ><img src="<?php echo static_url('static/images/'.$this->appfolder.'/nexta.gif')?>"></a><a href=""><img src="<?php echo static_url('static/images/'.$this->appfolder.'/next.gif')?>"></a>共98条记录 显示1/12</div>
</div>

<script type="text/javascript">
var num=$("#ullwidtha li").length;
$("#ullwidtha").css("width",num*150);
var page=1;
function move_right()
{
     if(datadiv.scrollLeft<=(num*150-150)){
     datadiv.scrollLeft+=150;
     page+=1;
     if (page>=num)
     $("#right_a").css("color","#f0f0f0");
}
}
function move_left()
{
    if(datadiv.scrollLeft>=0)
    datadiv.scrollLeft-=150;
    page-=1;
    if (page<=0)
    $("#left_a").css("color","#f0f0f0");
}
</script>

</body>

<?php $this->load->view(''.$this->appfolder.'/footer_view');?>