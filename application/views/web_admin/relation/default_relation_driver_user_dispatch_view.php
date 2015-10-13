<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
var switch_url = "<?php echo site_url('"+appfolder+"/relation_driver_user_dispatch/index/')?>";

$(function() {
    $("select[name=user_dispatch_id]").change(function() {
        window.location.href = switch_url + '/?user_dispatch_id=' + $(this).val();
    });
});
</script>

<body>
<div class="warrper">
    <div class="content">
        
        <?php $this->load->view(''.$this->appfolder.'/path_view');?>

        <div class="shop">
            <div class="shop_content">
                <div class="search_box">
                    <form method="get" action="<?php echo site_url(''.$this->appfolder.'/relation_driver_user_dispatch')?>">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="100">所属调度：</td>
                            <td>
                                <select name="user_dispatch_id">
                                    <?php echo $get_user_dispatch_options?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="button" class="btn" onclick="window.location.reload();" value="刷新页面">
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>

        <b>已关联数据：</b>
        <iframe id="current_iframe" name="current_iframe" src="<?php echo site_url(''.$this->appfolder.'/relation_driver_user_dispatch/current_data/?user_dispatch_id='.$user_dispatch_id.'')?>" width="100%" height="400" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes"></iframe>

        <b>所有线路和司机：</b>
        <iframe  id="all_iframe" name="all_iframe" src="<?php echo site_url(''.$this->appfolder.'/relation_driver_user_dispatch/route_driver_all_data/?user_dispatch_id='.$user_dispatch_id.'')?>" width="100%" height="auto" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes"></iframe>
    </div>
</div>
</body>
</html>