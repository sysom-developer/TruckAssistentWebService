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
    <form action="<?php echo site_url(''.$this->appfolder.'/shipper_company/act_edit_data')?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <div class="forms_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100">货运公司名称：</td>
                <td>
                    <input type="text" class="txt" name="shipper_company_name" value="<?php echo $data['shipper_company_name']?>">
                </td>
            </tr>
            <tr>
                <td>邮编：</td>
                <td>
                    <input type="text" class="txt" name="zipcode" value="<?php echo $data['zipcode']?>">
                </td>
            </tr>
            <tr>
                <td>固定电话：</td>
                <td>
                    <input type="text" class="txt" name="shipper_phone" value="<?php echo $data['shipper_phone']?>">
                </td>
            </tr>
            <tr>
                <td>传真：</td>
                <td>
                    <input type="text" class="txt" name="shipper_fax" value="<?php echo $data['shipper_fax']?>">
                </td>
            </tr>
            <tr>
                <td>货运公司地址：</td>
                <td>
                    <input type="text" class="txt" name="shipper_company_addr" value="<?php echo $data['shipper_company_addr']?>">
                </td>
            </tr>
            <tr>
                <td>货运公司简介：</td>
                <td>
                    <input type="text" class="txt" name="shipper_company_desc" value="<?php echo $data['shipper_company_desc']?>">
                </td>
            </tr>
            <tr>
                <td>积分：</td>
                <td>
                    <input type="text" class="txt" name="shipper_company_score" value="<?php echo $data['shipper_company_score']?>">
                </td>
            </tr>
            <tr>
                <td>是否是专线公司：</td>
                <td>
                    <select name="is_special">
                        <option value="1" <?php if ($data['is_special'] == 1) { echo "selected";}?>>是</option>
                        <option value="2" <?php if ($data['is_special'] == 2) { echo "selected";}?>>不是</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>是否可查询：</td>
                <td>
                    <select name="is_select">
                        <option value="1" <?php if ($data['is_select'] == 1) { echo "selected";}?>>是</option>
                        <option value="2" <?php if ($data['is_select'] == 2) { echo "selected";}?>>否</option>
                    </select>
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