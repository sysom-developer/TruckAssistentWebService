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
                    <a href="<?php echo site_url(''.$this->appfolder.'/shipper/add_data')?>" class="add">添 加</a>
                </p>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>货主名称</th>
                <th>登陆名</th>
                <th>货主电话</th>
                <!-- <th>身份证号码</th> -->
                <th>货主类型</th>
                <th>所属货运公司</th>
                <th>是否公司账户</th>
                <th>货主头像</th>
                <th>公司或跟人照片</th>
                <th>身份证照片</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/shipper/detail/'.$data['shipper_id'].'')?>"><?php echo $data['shipper_id']?></a></td>
                <td>
                    <?php echo $data['shipper_name']?>
                </td>
                <td>
                    <?php echo $data['login_name']?>
                </td>
                <td>
                    <?php echo $data['shipper_mobile']?>
                </td>
                <!-- <td>
                    <?php echo $data['shipper_card_num']?>
                </td> -->
                <td>
                    <?php
                    $shipper_type = '';
                    switch ($data['shipper_type']) {
                        case 1:
                            $shipper_type = '货主';
                            break;
                        case 2:
                            $shipper_type = '中介';
                            break;
                    }
                    echo $shipper_type;
                    ?>
                </td>
                <td>
                    <?php echo $data['shipper_company_data']['shipper_company_name']?>
                </td>
                <td>
                    <?php
                    $is_admin = '';
                    switch ($data['is_admin']) {
                        case 0:
                            $is_admin = '不是';
                            break;
                        case 1:
                            $is_admin = '是';
                            break;
                    }
                    echo $is_admin;
                    ?>
                </td>
                <td>
                    <?php if ($data['shipper_head_icon_http_file']) {?>
                    <a href="<?php echo $data['shipper_head_icon_http_file']?>" target="_blank">查看</a>
                    <?php }?>
                </td>
                <td>
                    <?php if ($data['shipper_pic_http_file']) {?>
                    <a href="<?php echo $data['shipper_pic_http_file']?>" target="_blank">查看</a>
                    <?php }?>
                </td>
                <td>
                    <?php if ($data['shipper_card_pic_http_file']) {?>
                    <a href="<?php echo $data['shipper_card_pic_http_file']?>" target="_blank">查看</a>
                    <?php }?>
                </td>
                <td>
                    <?php
                    $shipper_status = '';
                    switch ($data['shipper_status']) {
                        case 1:
                            $shipper_status = '<font color="green">有效</font>';
                            break;
                        case 2:
                            $shipper_status = '<font color="red">无效</font>';
                            break;
                    }
                    echo $shipper_status;
                    ?>
                </td>
                <td>
                    <?php echo $data['create_time']?>
                </td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/shipper/edit_data/'.$data['shipper_id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/shipper/delete/'.$data['shipper_id'].'')?>';}">删除</a>
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