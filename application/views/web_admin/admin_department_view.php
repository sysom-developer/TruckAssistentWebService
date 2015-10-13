<?php $this->load->view(''.$this->appfolder.'/header_view');?>

<script type="text/javascript">
$(function() {
    $("tr[name=data_list]").mousemove(function() {
        $(this).css("background-color", "#E6E6E6");
    });

    $("tr[name=data_list]").mouseout(function() {
        $(this).css("background-color", "#F5F5F5");
    });

    $("input[name=checkbox_id]").click(function() {
        if ($(this).prop("checked") == true) {
            $(this).prop({checked:"checked"});
        } else {
            $(this).removeAttr("checked");
        }

        $.select_ids();
    });

    $("input[name=select_all]").click(function() {
        if ($(this).prop("checked") == true) {
            $("input[name=checkbox_id]").each(function(){
                $(this).prop({checked:"checked"});
            });
        } else {
            $("input[name=checkbox_id]").each(function(){
                $(this).removeAttr("checked");
            });
        }

        $.select_ids();
    });

    $.select_ids = function() {
        var ids = "";
        $("input[name=checkbox_id]").each(function() {
            if ($(this).prop("checked") == true) {
                ids += $(this).val()+",";
            }
        });
        $("#select_ids").val(ids);
    };

    $("input[name=delete_all]").click(function() {
        if (window.confirm("确认删除？")) {
            return true;
        }

        return false;
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
                <form action="<?php echo site_url(''.$this->appfolder.'/admin_department')?>" method="get">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100">部门名称：</td>
                        <td><input type="text" class="txt" name="depart_name" value="<?php echo $depart_name?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:10px;">
                            <input type="submit" class="btn" value="搜 索" />
                            <input type="button" class="btn" onclick="javascript:window.history.back();" value="返 回">

                            <a href="<?php echo site_url(''.$this->appfolder.'/admin_department/add_data')?>" class="add">添 加</a>
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
                <th><input type="checkbox" name="select_all" /></th>
                <th>ID</th>
                <th>部门名称</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>
            <?php 
            if (!empty($data_list)) {
                foreach ($data_list as $data) {
            ?>
            <tr name="data_list">
                <td><input type="checkbox" name="checkbox_id" value="<?php echo $data['id']?>" /></td>
                <td><?php echo $data['id']?></td>
                <td><a href="<?php echo site_url(''.$this->appfolder.'/admin_department/detail/'.$data['id'].'')?>"><?php echo $data['depart_name']?></a></td>
                <td><?php echo date("Y-m-d H:i:s", $data['cretime'])?></td>
                <td><?php echo date("Y-m-d H:i:s", $data['updatetime'])?></td>
                <td>
                    <a href="<?php echo site_url(''.$this->appfolder.'/admin_department/edit_data/'.$data['id'].'')?>">编辑</a>
                    <a href="javascript:;" onClick="javascript: if (window.confirm('确认删除？')) { window.location.href='<?php echo site_url(''.$this->appfolder.'/admin_department/delete/'.$data['id'].'')?>';}">删除</a>
                </td>
            </tr>
            <?php 
                }
            }
            ?>
        </table>
        <div class="pager">
            <form method="post" style="float:left;" action="<?php echo site_url(''.$this->appfolder.'/admin_department/delete_all')?>">
            <input type="hidden" id="select_ids" name="select_ids" value="">
            <input type="submit" class="btn" name="delete_all" style="margin:10px 0px 0px 10px;" value="删 除" />
            </form>
            <span class="fun">
            <?php echo $links?>
            </span>
        </div>
    </div>
</div>
</div>
</body>
</html>