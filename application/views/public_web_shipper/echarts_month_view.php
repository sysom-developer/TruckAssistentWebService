<div class="chart">
   <div class="condition">
        <span class="leftbutton">
            <a href="<?php echo site_url($this->appfolder.'/main/?echarts_type='.$echarts_type.'')?>">
                <div <?php if ($stat_type == 'order_go_out') { echo 'class="current"';}?>>运单发车统计</div>
            </a>
            <a href="<?php echo site_url($this->appfolder.'/main/?stat_type=order_freight&echarts_type='.$echarts_type.'')?>">
                <div <?php if ($stat_type == 'order_freight') { echo 'class="current"';}?>>运单金额统计</div>
            </a>
        </span>
        <span class="data">
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

$.post(apppath + fetch_class + '/ajax_get_month_data', {stat_type: stat_type}, function(json) {
        if (json.code == 'success') {
            for (var i=1; i<=12; i++) {
                if (json.month_data[i] == undefined) {
                    json.month_data[i] = 0;
                }
            };

            var lineChartData = {
                labels : ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
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
                            json.month_data[1], json.month_data[2], 
                            json.month_data[3], json.month_data[4], 
                            json.month_data[5], json.month_data[6], 
                            json.month_data[7], json.month_data[8],
                            json.month_data[9], json.month_data[10],
                            json.month_data[11], json.month_data[12],
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
                    responsive: true
                };
            }

            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx).Line(lineChartData, defaults);
        }
}, 'json');
</script>