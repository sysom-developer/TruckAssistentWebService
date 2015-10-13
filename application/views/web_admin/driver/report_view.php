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
                <form method="get" action="<?php echo site_url(''.$this->appfolder.'/report')?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100">司机姓名：</td>
                        <td><input type='text' class='txt' name='driver_name' value='<?php echo $driver_name?>'></td>
                    </tr>
                    <tr>
                        <td>状态：</td>
                        <td>
                            <select name="status">
                                <option value="all" <?php if ($status == 'all') { echo 'selected';}?>>全部</option>
                                <option value="0" <?php if (empty($status)) { echo 'selected';}?>>未处理</option>
                                <option value="1" <?php if ($status == 1) { echo 'selected';}?>>已采纳</option>
                                <option value="2" <?php if ($status == 2) { echo 'selected';}?>>未采纳</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:10px;">
                            <input type="submit" class="btn" value="搜 索" />
                            <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回">

                            <a href="javascript:;" onClick="javascript:window.history.back();" class="add">返 回</a>
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
                <th>司机姓名</th>
                <th>设备</th>
                <th>反馈内容</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><a href="<?php echo site_url(''.$this->appfolder.'/report/detail/'.$data['id'].'')?>"><?php echo $data['id']?></a></td>
                <td>
                    <?php echo $data['driver_data']['driver_name']?>
                </td>
                <td>
                    <?php echo $data['device']?>
                </td>
                <td>
                    <?php echo $data['content']?>
                </td>
                <td>
                    <?php
                    switch ($data['status']) {
                        case 0:
                            $status = '未处理';
                            break;
                        case 1:
                            $status = '<font style="color: green;">已采纳</font>';
                            break;
                        case 2:
                            $status = '<font style="color: red;">未采纳</font>';
                            break;
                    }
                    echo $status;
                    ?>
                </td>
                <td>
                    <?php echo date('Y-m-d H:i:s', $data['cretime'])?>
                </td>
                <td>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认操作')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/report/update/?id='.$data['id'].'&status=1')?>';}">已采纳</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认操作？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/report/update/?id='.$data['id'].'&status=2')?>';}">未采纳</a>
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