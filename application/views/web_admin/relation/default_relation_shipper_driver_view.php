<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
var switch_url = "<?php echo site_url('"+appfolder+"/relation_shipper_driver/index/')?>";

$(function() {
    $("select[name=shipper_company_id]").change(function() {
        window.location.href = switch_url + '/?shipper_company_id=' + $(this).val();
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
                    <form method="get" action="<?php echo site_url(''.$this->appfolder.'/relation_shipper_driver')?>">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="100">所属货运公司：</td>
                            <td>
                                <select name="shipper_company_id">
                                    <?php echo $get_ushipper_company_options?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" class="btn" value="搜 索">
                                <input type="button" class="btn" onclick="window.location.reload();" value="刷新页面">
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>

        <b>当前调度关联司机：<?php echo $relation_total?></b>
        <iframe id="current_iframe" name="current_iframe" src="<?php echo site_url(''.$this->appfolder.'/relation_shipper_driver/current_data/?shipper_company_id='.$shipper_company_id.'')?>" width="100%" height="331" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes"></iframe>

        <b>所有司机：</b>
        <iframe  id="all_iframe" name="all_iframe" src="<?php echo site_url(''.$this->appfolder.'/relation_shipper_driver/all_data/?shipper_company_id='.$shipper_company_id.'')?>" width="100%" height="331" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes"></iframe>
    </div>
</div>
</body>
</html>