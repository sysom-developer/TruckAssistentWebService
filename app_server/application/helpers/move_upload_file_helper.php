<?php 

/**
 * 移动上传文件至data目录
 * 写入thy_attachment表
 * 更新时需赋值update_attachment_id
 */

if ( ! function_exists('move_upload_file'))
{
    function move_upload_file($attachment_id, $update_attachment_id = 0)
    {
        $CI =& get_instance();

        $attachment_tmp_data = $CI->attachment_service->get_attachment_tmp_by_id($attachment_id);

        $source_file = FCPATH.$attachment_tmp_data['filepath'].$attachment_tmp_data['filename'];

        $filepath = "data".substr($attachment_tmp_data['filepath'], stripos($attachment_tmp_data['filepath'], "data_tmp/") + 8);
        $file = FCPATH.$filepath.$attachment_tmp_data['filename'];
        $CI->upload_conf->recursive_mkdir($filepath, FCPATH);

        $file_data = read_file($source_file);
        if (!write_file($file, $file_data)) {
            show_error('Unable to write the file: '.$file.'，<a href="javascript:;" onclick="javascript:window.history.back();">返回</a>', 500, '系统提示');
        }

        $time = time();

        $data = array(
            'filetype' => $attachment_tmp_data['filetype'],
            'filename' => $attachment_tmp_data['filename'],
            'filesize' => $attachment_tmp_data['filesize'],
            'filepath' => $filepath,
            'cretime' => $time,
            'updatetime' => $time,
        );

        // 更新
        if ($update_attachment_id) {
            unset($data['cretime']);

            $attachment_data = $CI->attachment_service->get_attachment_by_id($update_attachment_id);
            if ($attachment_data['http_file'] !== FALSE) {
                @unlink(FCPATH.$filepath.$attachment_data['filename']);

                $where = array(
                    'id' => $update_attachment_id,
                );
                $CI->common_model->update('attachment', $data, $where);

                return $update_attachment_id;
            }
        }

        // 新增
        $insert_id = $CI->common_model->insert('attachment', $data);

        return $insert_id;
    }
}
