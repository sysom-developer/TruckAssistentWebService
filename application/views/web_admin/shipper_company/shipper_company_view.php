<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
    $("tr[name=data_list]").mousemove(function() {
        $("tr[name=data_list]").css("background-color", "#F5F5F5");
        $(this).css("background-color", "#E6E6E6");
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
                <p>
                    <a href="javascript:;" onClick="javascript:window.history.back();" class="add">返 回</a>
                    <a href="<?php echo site_url(''.$this->appfolder.'/shipper_company/add_data')?>" class="add">添 加</a>
                </p>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>货运公司名称</th>
                <th>邮编</th>
                <th>固定电话</th>
                <th>传真</th>
                <th>货运公司地址</th>
                <th>货运公司简介</th>
                <th>是否专线公司</th>
                <th>积分</th>
                <th>是否可查询</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/shipper_company/detail/'.$data['id'].'')?>"><?php echo $data['id']?></a></td>
                <td>
                    <?php echo $data['shipper_company_name']?>
                </td>
                <td>
                    <?php echo $data['zipcode']?>
                </td>
                <td>
                    <?php echo $data['shipper_phone']?>
                </td>
                <td>
                    <?php echo $data['shipper_fax']?>
                </td>
                <td>
                    <?php echo $data['shipper_company_addr']?>
                </td>
                <td>
                    <?php echo $data['shipper_company_desc']?>
                </td>
                <td>
                    <?php
                    $is_special = '';
                    switch ($data['is_special']) {
                        case 1:
                            $is_special = '是';
                            break;
                        case 2:
                            $is_special = '不是';
                            break;
                    }
                    echo $is_special;
                    ?>
                </td>
                <td>
                    <?php echo $data['shipper_company_score']?>
                </td>
                <td>
                    <?php
                    $is_select = '';
                    switch ($data['is_select']) {
                        case 1:
                            $is_select = '是';
                            break;
                        case 2:
                            $is_select = '不是';
                            break;
                    }
                    echo $is_select;
                    ?>
                </td>
                <td>
                    <?php echo $data['create_time']?>
                </td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/shipper_company/edit_data/'.$data['id'].'')?>">编辑</a>
                    <!-- <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/shipper_company/delete/'.$data['id'].'')?>';}">删除</a> -->
                </td>
            </tr>
            <?php 
                }
            }
            ?>
        </table>
        <div class="pager">
            <span class="fun">
            <?php echo $links?>
            </span>
        </div>
    </div>
</div>
</div>
</body>
</html>