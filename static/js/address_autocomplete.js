$(function () {
    // 装货地点
    $("input[name=good_load_addr]").keyup(function() {
        var start_city_id = $("input[name=start_city_id], select[name=start_city_id]").val();
        var good_load_addr = $(this).val();

        if (good_load_addr.length < 2) {
            return false;
        }

        $(".good-load-addr-loading").show();

        $.post(apppath + 'order/ajax_start_location_baidumap_place', {start_city_id: start_city_id, good_load_addr: good_load_addr}, function(json) {
            $(".error").hide();
            if (json.code == 'success') {
                var address_html = '';
                for (var i = json.address_list.length - 1; i >= 0; i--) {
                    address_html += "<a href='javascript:;' location='"+json.address_list[i].location+"' address='"+json.address_list[i].address_detail+"'>"+json.address_list[i].address_data+"</a>";
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
        var address = $(this).attr("address");
        var location = $(this).attr("location");
        
        $("input[name=good_load_addr]").val(address);
        $("input[name=good_load_addr_lat_lng]").val(location);
        $(this).parent("div.autocomplete-item-data").hide();
    });

    // 卸货地点
    $("input[name=good_unload_addr]").keyup(function() {
        var end_city_id = $("input[name=end_city_id], select[name=end_city_id]").val();
        var good_unload_addr = $(this).val();

        if (good_unload_addr.length < 2) {
            return false;
        }

        $(".good-unload-addr-loading").show();

        $.post(apppath + 'order/ajax_end_location_baidumap_place', {end_city_id: end_city_id, good_unload_addr: good_unload_addr}, function(json) {
            $(".error").hide();

            if (json.code == 'success') {
                var address_html = '';
                for (var i = json.address_list.length - 1; i >= 0; i--) {
                    address_html += "<a href='javascript:;' location='"+json.address_list[i].location+"' address='"+json.address_list[i].address_detail+"'>"+json.address_list[i].address_data+"</a>";
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
        var address = $(this).attr("address");
        var location = $(this).attr("location");
        
        $("input[name=good_unload_addr]").val(address);
        $("input[name=good_unload_addr_lat_lng]").val(location);
        $(this).parent("div.good-unload-addr-address-list").hide();
    });
});