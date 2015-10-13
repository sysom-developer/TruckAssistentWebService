<div class="chart">
   <div class="condition">
        <span class="leftbutton">
            <a href="<?php echo site_url($this->appfolder.'/main/?echarts_type='.$echarts_type.'')?>">
                <div <?php if ($stat_type == 'order_go_out') { echo 'class="current"';}?>>运单发车统计</div>
            </a>
            <a href="<?php echo site_url($this->appfolder.'/main/?stat_type=order_freight&echarts_type='.$echarts_type.'')?>">
                <div <?php if ($stat_type == 'order_freight') { echo 'class="current"';}?>>运单金额统计
                </div>
            </a>
        </span>
        <span class="data">
            <div id="left_" onclick="move_left();"><</div>
            <div id="datadiv">
                <div id="ullwidth">
                    <ul>
                        <?php
                        $i = 1;
                        $page = $i;
                        foreach ($get_week as $value) {
                            if ($value[4] == 1) {
                                $page = $i;
                            }
                        ?>
                        <li>
                            <input type="hidden" name="start_time" value="<?php echo $value[2]?>">
                            <input type="hidden" name="end_time" value="<?php echo $value[3]?>">
                            <?php echo $value[0].' - '.$value[1]?>
                        </li>
                        <?php
                            $i++;
                        }
                        ?>
                    </ul>
                 </div>
            </div>
            <div id="right_" onclick="move_right();">></div>
        </span>
        <span class="week">
            <a style="<?php echo $echarts_month_style?>" href="<?php echo site_url($this->appfolder.'/main/index/?echarts_type=month&stat_type='.$stat_type.'')?>"><div <?php if ($echarts_type == 'month') { echo 'class="current"';}?> id="month">月</div></a>
            <a style="<?php echo $echarts_day_style?>" href="<?php echo site_url($this->appfolder.'/main/index/?echarts_type=day&stat_type='.$stat_type.'')?>"><div <?php if ($echarts_type == 'day') { echo 'class="current"';}?> id="day">日</div></a>
        </span>
   </div>
   <div class="grid">
        <div class="countinfo">
            <canvas id="canvas" height="160" width="600" style="display:block;"></canvas>
        </div>
    </div>
</div>

<script type="text/javascript">
var stat_type = '<?php echo $stat_type?>';
var num = $("#ullwidth li").length;
$("#ullwidth").css("width", num * 150);
var page = <?php echo $page?>;
move_length = page * 150;
if(datadiv.scrollLeft<=(num*150-move_length)){
    datadiv.scrollLeft+=move_length;
    if (page>=num)
        $("#right_").css("color","#999");
}
// 自动定到本周，显示本周数据
var start_time = $("#ullwidth li").eq(page-1).find("input[name=start_time]").val();
var end_time = $("#ullwidth li").eq(page-1).find("input[name=end_time]").val();
$.post(apppath + fetch_class + '/ajax_get_week_data', {start_time: start_time, end_time: end_time, stat_type: stat_type}, function(json) {
        if (json.code == 'success') {
            var max_y = 0;
            for (var i=1; i<=7; i++) {
                json.week_data[i] = parseInt(json.week_data[i]);

                if (json.week_data[i] > max_y) {
                    max_y = json.week_data[i];
                }
            };

            var lineChartData = {
                labels : [
                    '周一'+json.week_name[1].day_name, '周二'+json.week_name[2].day_name,
                    '周三'+json.week_name[3].day_name, '周四'+json.week_name[4].day_name,
                    '周五'+json.week_name[5].day_name, '周六'+json.week_name[6].day_name,
                    '周日'+json.week_name[7].day_name,
                ],
                datasets : [
                    {
                        label: "My Second dataset",
                        fillColor : "rgba(254,120,47,0.2)",
                        strokeColor : "rgba(254,120,47,1)",
                        pointColor : "rgba(255,255,255,1)",
                        pointStrokeColor : "#fe782f",
                        pointHighlightFill : "#fe782f",
                        pointHighlightStroke : "rgba(255,172,82,1)",
                        data : [
                            json.week_data[1], json.week_data[2], 
                            json.week_data[3], json.week_data[4], 
                            json.week_data[5], json.week_data[6], 
                            json.week_data[7]
                        ]
                    }
                ]
            };

            var tmp_scale_label = "<%=value/10000%>万";
            if (json.is_zero == 0) {
                tmp_scale_label = "<%=value/1%>万";
            }

            var defaults = {
                scaleShowLabels : true,
                scaleLabel : tmp_scale_label,
                responsive: true
            };
            if (stat_type == 'order_go_out') {
                defaults = {
                    scaleOverride: true ,   //是否用硬编码重写y轴网格线
                    scaleSteps: max_y,        //y轴刻度的个数
                    scaleStepWidth: 1,   //y轴每个刻度的宽度
                    scaleStartValue: 0,    //y轴的起始值
                    responsive: true
                };
            }

            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx).Line(lineChartData, defaults);
        }
}, 'json');

function move_right()
{
    if(datadiv.scrollLeft<(num*150-150)){  // if(datadiv.scrollLeft<=(num*150-150)){
        datadiv.scrollLeft+=150;
        page+=1;
        if (page>=num)
            $("#right_").css("color","#999");
    }

    // 加载数据
    var start_time = $("#ullwidth li").eq(page-1).find("input[name=start_time]").val();
    var end_time = $("#ullwidth li").eq(page-1).find("input[name=end_time]").val();
    $.post(apppath + fetch_class + '/ajax_get_week_data', {start_time: start_time, end_time: end_time, stat_type: stat_type}, function(json) {
            if (json.code == 'success') {
                var max_y = 0;
                for (var i=1; i<=7; i++) {
                    json.week_data[i] = parseInt(json.week_data[i]);

                    if (json.week_data[i] > max_y) {
                        max_y = json.week_data[i];
                    }
                };

                var lineChartData = {
                    labels : [
                        '周一'+json.week_name[1].day_name, '周二'+json.week_name[2].day_name,
                        '周三'+json.week_name[3].day_name, '周四'+json.week_name[4].day_name,
                        '周五'+json.week_name[5].day_name, '周六'+json.week_name[6].day_name,
                        '周日'+json.week_name[7].day_name,
                    ],
                    datasets : [
                        {
                            label: "My Second dataset",
                            fillColor : "rgba(254,120,47,0.2)",
                            strokeColor : "rgba(254,120,47,1)",
                            pointColor : "rgba(255,255,255,1)",
                            pointStrokeColor : "#fe782f",
                            pointHighlightFill : "#fe782f",
                            pointHighlightStroke : "rgba(255,172,82,1)",
                            data : [
                                json.week_data[1], json.week_data[2], 
                                json.week_data[3], json.week_data[4], 
                                json.week_data[5], json.week_data[6], 
                                json.week_data[7]
                            ]
                        }
                    ]
                };

                var defaults = {
                    scaleShowLabels : true,
                    scaleLabel : "<%=value/10000%>万",
                    responsive: true
                };
                if (stat_type == 'order_go_out') {
                    defaults = {
                        scaleOverride: true ,   //是否用硬编码重写y轴网格线
                        scaleSteps: max_y,        //y轴刻度的个数
                        scaleStepWidth: 1,   //y轴每个刻度的宽度
                        scaleStartValue: 0,    //y轴的起始值
                        responsive: true
                    };
                }

                var ctx = document.getElementById("canvas").getContext("2d");
                window.myLine = new Chart(ctx).Line(lineChartData, defaults);
            }
    }, 'json');
}
function move_left()
{
    if(datadiv.scrollLeft>=0)
        datadiv.scrollLeft-=150;

    if (page > 1) {
        page-=1;
    }
    if (page<=0)
        $("#left_").css("color","#999");

    // 加载数据
    var start_time = $("#ullwidth li").eq(page-1).find("input[name=start_time]").val();
    var end_time = $("#ullwidth li").eq(page-1).find("input[name=end_time]").val();
    $.post(apppath + fetch_class + '/ajax_get_week_data', {start_time: start_time, end_time: end_time, stat_type: stat_type}, function(json) {
            if (json.code == 'success') {

                var max_y = 0;
                for (var i=1; i<=7; i++) {
                    json.week_data[i] = parseInt(json.week_data[i]);

                    if (json.week_data[i] > max_y) {
                        max_y = json.week_data[i];
                    }
                };

                var lineChartData = {
                    labels : [
                        '周一'+json.week_name[1].day_name, '周二'+json.week_name[2].day_name,
                        '周三'+json.week_name[3].day_name, '周四'+json.week_name[4].day_name,
                        '周五'+json.week_name[5].day_name, '周六'+json.week_name[6].day_name,
                        '周日'+json.week_name[7].day_name,
                    ],
                    datasets : [
                        {
                            label: "My Second dataset",
                            fillColor : "rgba(254,120,47,0.2)",
                            strokeColor : "rgba(254,120,47,1)",
                            pointColor : "rgba(255,255,255,1)",
                            pointStrokeColor : "#fe782f",
                            pointHighlightFill : "#fe782f",
                            pointHighlightStroke : "rgba(255,172,82,1)",
                            data : [
                                json.week_data[1], json.week_data[2], 
                                json.week_data[3], json.week_data[4], 
                                json.week_data[5], json.week_data[6], 
                                json.week_data[7]
                            ]
                        }
                    ]
                };

                var defaults = {
                    scaleShowLabels : true,
                    scaleLabel : "<%=value/10000%>万",
                    responsive: true
                };
                if (stat_type == 'order_go_out') {
                    defaults = {
                        scaleOverride: true ,   //是否用硬编码重写y轴网格线
                        scaleSteps: max_y,        //y轴刻度的个数
                        scaleStepWidth: 1,   //y轴每个刻度的宽度
                        scaleStartValue: 0,    //y轴的起始值
                        responsive: true
                    };
                }

                var ctx = document.getElementById("canvas").getContext("2d");
                window.myLine = new Chart(ctx).Line(lineChartData, defaults);
            }
    }, 'json');
}
</script>