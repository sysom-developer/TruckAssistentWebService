<script type="text/javascript">
$(function() {
    // 显示指派运单层
    $(".assign_order").click(function() {
        var vehicle_id = $(this).attr("vehicle_id");
        $("select[name=vehicle_id]").val(vehicle_id);

        $(".orderedit").show();

        $(".mask").show();
        $(".editorcontent").show();

        $(".head").addClass("fixed");
        $(".container").addClass("serachfixed");
    });

    // 出发地
    $("select[name=start_province_id]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=start_city_id]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + fetch_class + '/ajax_get_region', {id: id}, function(json) {
            if (json.code == 'success') {
                var option = '<option value="0">请选择市</option>';
                for (var i=0; i<json.data.length; i++) {
                    option += '<option value="'+json.data[i].id+'">'+json.data[i].region_name+'</option>';
                }

                $("select[name=start_city_id]").html(option);
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });

    // 装货地点
    $("input[name=good_load_addr]").keyup(function() {
        var start_province_id = $("select[name=start_province_id]").val();
        var good_load_addr = $(this).val();

        if (good_load_addr.length < 2) {
            return false;
        }

        $(".good-load-addr-loading").show();

        $.post(apppath + 'vehicle/ajax_start_location_baidumap_place', {start_province_id: start_province_id, good_load_addr: good_load_addr}, function(json) {
            $(".error").hide();
            if (json.code == 'success') {
                var address_html = '';
                for (var i = json.address_list.length - 1; i >= 0; i--) {
                    address_html += "<a href='javascript:;' location='"+json.address_list[i].location+"' name='"+json.address_list[i].name+"'>"+json.address_list[i].address_data+"</a>";
                };
                $(".autocomplete-item-data").html(address_html);
                $(".autocomplete-item-data").show();
                $(".good-load-addr-loading").hide();
            } else {
                $(".error").find("span").html(json.code);
                $(".error").show();
                $(".good-load-addr-loading").hide();

                return false;
            }
        }, 'json');

        return false;
    });
    //选中标签
    $(".autocomplete-item-data").delegate("a", "click", function() {
        var name = $(this).attr("name");
        var location = $(this).attr("location");
        
        $("input[name=good_load_addr]").val(name);
        $("input[name=good_load_addr_lat_lng]").val(location);
        $(this).parent("div.autocomplete-item-data").hide();
    });

    // 目的地
    $("select[name=end_province_id]").change(function() {
        var id = $(this).val();

        if (id == 0) {
            $("select[name=end_city_id]").html('<option value="0">请选择市</option>');
            return false;
        }

        $.post(apppath + fetch_class + '/ajax_get_region', {id: id}, function(json) {
            if (json.code == 'success') {
                var option = '<option value="0">请选择市</option>';
                for (var i=0; i<json.data.length; i++) {
                    option += '<option value="'+json.data[i].id+'">'+json.data[i].region_name+'</option>';
                }

                $("select[name=end_city_id]").html(option);
            } else {
                alert(json.code);

                return false;
            }
        }, 'json');
    });

    // 卸货地点
    $("input[name=good_unload_addr]").keyup(function() {
        var end_province_id = $("select[name=end_province_id]").val();
        var good_unload_addr = $(this).val();

        if (good_unload_addr.length < 2) {
            return false;
        }

        $(".good-unload-addr-loading").show();

        $.post(apppath + 'vehicle/ajax_end_location_baidumap_place', {end_province_id: end_province_id, good_unload_addr: good_unload_addr}, function(json) {
            $(".error").hide();

            if (json.code == 'success') {
                var address_html = '';
                for (var i = json.address_list.length - 1; i >= 0; i--) {
                    address_html += "<a href='javascript:;' location='"+json.address_list[i].location+"' name='"+json.address_list[i].name+"'>"+json.address_list[i].address_data+"</a>";
                };
                $(".good-unload-addr-address-list").html(address_html);
                $(".good-unload-addr-address-list").show();
                $(".good-unload-addr-loading").hide();
            } else {
                $(".error").find("span").html(json.code);
                $(".error").show();
                $(".good-unload-addr-loading").hide();

                return false;
            }
        }, 'json');

        return false;
    });
    //选中标签
    $(".good-unload-addr-address-list").delegate("a", "click", function() {
        var name = $(this).attr("name");
        var location = $(this).attr("location");
        
        $("input[name=good_unload_addr]").val(name);
        $("input[name=good_unload_addr_lat_lng]").val(location);
        $(this).parent("div.good-unload-addr-address-list").hide();
    });

    $('select[name=vehicle_id] option:first').attr('selected', true);

    // 指派运单提交
    $(".publish-order-submit").click(function() {
        var _this = $(this);
        $(this).attr('disabled', true);
        $(".error").css("background", "#f26b54").hide();

        $.post(apppath + 'vehicle/ajax_do_publish_order', $("form[name=publish_order_form]").serialize(), function(json) {
            if (json.code == 'success') {
                $(".error").find("span").html("指派运单成功");
                $(".error").css("background-color", "#5fc53d");
                $(".error").show();
                window.setTimeout("window.location.reload();", 1000);
            } else {
                _this.attr('disabled', false);
                $(".error").find("span").html(json.code);
                $(".error").show();

                return false;
            }
        }, 'json');

        return false;
    });

    // 点击空白处隐藏poi
    $(document).delegate("body", "click", function() {
        $(".autocomplete-item-data").hide();
    });
    $(document).delegate("body", "click", function() {
        $(".good-unload-addr-address-list").hide();
    });
});

</script>

<!--新建运单开始-->
<form name="publish_order_form" action="" method="post">
<div class="orderedit" style="display:none;">
    <div class="error" style="display: none;width:350px;height:50px;backrgound:rgb(242,107,84);float:left;margin-left:360px;border-radius:3px;line-height:50px;text-align:center;margin-top:30px;box-shadow:0px 1px 2px #5f5f5f;">
	<span style="color:#fff;"></span>
	</div>
    <div class="close"></div>
    <div class="editnr">
        <dl>
            <dt><span style="font-size: 24px; color: rgb(255, 0, 0); left: 30px; top: -10px; float: left; position: relative; padding-top: 15px;">*</span>始发城市</dt>
            <dd>
                <select name="start_province_id" class="dual-select">
                    <option value="0">请选择省</option>
                    <?php echo $get_region_options?>
                </select>
                <select name="start_city_id" class="dual-select">
                    <option value="0">请选择始发城市</option>
                </select>
				<!-- <input name="good_load_addr" type="text" class="input placeholder" val="请选择始发城市" value="请选择始发城市" autocomplete="off"/>
				<div id="b">
        			<div class="menu_top">
        				<ul class="menu">
        					<li>
        						<a href="#" class="tablink arwlink">常用</a>
        						<ul>
        							<li><a href="#">北京</a></li>
        							<li><a href="#">上海</a></li>
        							<li><a href="#">广州</a></li>
        							<li><a href="#">深圳</a></li>
        							<li><a href="#">青岛</a></li>
        						</ul>
        					</li>
        					<li>
        						<a href="#" class="tablink arwlink">省</a>
        						<ul style="left:-113px;">
        							<li><a href="#">上海</a></li>
        							<li><a href="#">江苏</a></li>
        							<li><a href="#">浙江</a></li>
        							<li><a href="#">安徽</a></li>
        							<li><a href="#">福建</a></li>
        						</ul>
        					</li>
        					<li>
        						<a href="#" class="tablink arwlink">市</a>
        						<ul style="left:-206px;">
        							<li><a href="#">上海</a></li>
        							<li><a href="#">上海</a></li>
        							<li><a href="#">上海</a></li>
        							<li><a href="#">上海</a></li>
        							<li><a href="#">上海</a></li>
        						</ul>
        					</li>
        				</ul>
        			</div>
                </div> -->
            </dd>
        </dl>
        <dl>
            <dt>详细地址</dt>
            <dd>
                <input type="hidden" name="good_load_addr_lat_lng" value="">
                <input name="good_load_addr" type="text" class="input placeholder" val="请输入运单起点的详细地址" value="请输入运单起点的详细地址" autocomplete="off"/>
                <span class="good-load-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                <div class="item_list autocomplete-item-data">
                </div>
            </dd>
        </dl>
        <dl>
            <dt><span style="font-size: 24px; color: rgb(255, 0, 0); left: 30px; top: -10px; float: left; position: relative; padding-top: 15px;">*</span>目的城市</dt>
            <dd>
                <select name="end_province_id" class="dual-select">
                    <option value="0">请选择省</option>
                    <?php echo $get_region_options?>
                </select>
                <select name="end_city_id" class="dual-select">
                    <option value="0">请选择目的城市</option>
                </select>
				<!-- <input name="good_load_addr" type="text" class="input placeholder" val="请选择目的城市" value="请选择目的城市" autocomplete="off"/> -->
            </dd>
        </dl>
        <dl>
            <dt>详细地址</dt>
            <dd>
                <input type="hidden" name="good_unload_addr_lat_lng" value="">
                <input name="good_unload_addr" type="text" class="input placeholder" val="请输入运单起点的详细地址" value="请输入运单起点的详细地址" autocomplete="off"/>
                <span class="good-unload-addr-loading" style="display: none;"><img src="<?php echo static_url('static/images/loading.gif')?>"></span>
                <div class="item_list good-unload-addr-address-list">
                </div>
            </dd>
        </dl>
        <dl>
            <dt><span style="font-size: 24px; color: rgb(255, 0, 0); left: 30px; top: -10px; float: left; position: relative; padding-top: 15px;">*</span>指定货车</dt>
            <dd>
                <!-- <input name="good_unload_addr" type="text" class="input placeholder" val="请一位司机发车" value="请一位司机发车" autocomplete="off"/> -->
                <select class="singular-select" name="vehicle_id">
                    <?php echo $get_current_shipper_driver_vehicle_options?>
                </select>
            </dd>
        </dl>
    </div>
    <div class="operation">
        <input type="submit" class="save publish-order-submit" value="保存">
    </div>
</div>


</form>