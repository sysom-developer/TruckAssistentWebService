<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
    $("tr[name=data_list]").mousemove(function() {
        $(this).css("background-color", "#E6E6E6");
    });

    $("tr[name=data_list]").mouseout(function() {
        $(this).css("background-color", "#F5F5F5");
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
                <form action="<?php echo site_url(''.$this->appfolder.'/product_score')?>" method="get">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100">积分商品名称：</td>
                        <td><input type="text" class="txt" name="product_name" value="<?php echo $product_name?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:10px;">
                            <input type="submit" class="btn" value="搜 索" />
                            <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回">

                            <a href="<?php echo site_url(''.$this->appfolder.'/product_score/add_data')?>" class="add">添 加</a>
                        </td>
                    </tr>
                </table>            
                </form>
            </div>
        </div>
    </div>
    <div class="table_box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>描述</th>
                <th>图片</th>
                <th>类型</th>
                <th>所需积分</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><?php echo $data['id']?></td>
                <td><?php echo $data['product_name']?></td>
                <td><?php echo $data['product_desc']?></td>
                <td style="padding: 1px 0;">
                    <?php if ($data['product_img_http_file']) {?>
                    <a href="<?php echo $data['product_img_http_file']?>" target="_blank"><img src="<?php echo $data['product_img_http_file']?>" width="100" height="100"></a>
                    <?php } else { echo "-";}?>
                </td>
                <td><?php echo $data['exchange_type']?></td>
                <td><?php echo $data['exchange_num']?></td>
                <td><?php echo $data['status'] == 1 ? "<font color='green'>有效</font>" : "<font color='red'>无效</font>"?></td>
                <td><?php echo date("Y-m-d H:i:s", $data['cretime'])?></td>
                <td><?php echo date("Y-m-d H:i:s", $data['updatetime'])?></td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/product_score/edit_data/?id='.$data['id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/product_score/delete/?id='.$data['id'].'')?>';}">删除</a>
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