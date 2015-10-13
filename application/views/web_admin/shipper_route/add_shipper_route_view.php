<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<body>
<div class="warrper">
<div class="content">

    <?php $this->load->view(''.$this->appfolder.'/path_view');?>
    
    <div class="shop">
        <div class="shop_content">
            <div class="search_box">
                <p><strong><?php echo $path_name?></strong></p>
            </div>
        </div>
    </div>
    <form action="<?php echo site_url(''.$this->appfolder.'/shipper_route/act_add_data')?>" method="post" enctype="multipart/form-data">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100">专线公司名：</td>
                <td>
                    <select name="shipper_company_id">
                        <?php echo $get_shipper_company_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>所属线路：</td>
                <td>
                    <select name="route_id">
                        <?php echo $get_route_options?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>专线号码：</td>
                <td>
                    <input type="text" class="txt" name="shipper_company_tel" value="">
                </td>
            </tr>
            <tr>
                <td>运费：</td>
                <td>
                    <input type="text" class="txt" name="shipper_route_freight" value="">
                </td>
            </tr>
            <tr>
                <td>保证金：</td>
                <td>
                    <input type="text" class="txt" name="shipper_route_margin" value="">
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" class="btn" value="确 认" />
                    <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回" />
                </td>
            </tr>
        </table>
    </div>
    </form>
</div>
</div>
</body>
</html>