<?php 

/**
 * 上传图片文件公共函数
 * 默认存储临时目录data_tmp
 */

if ( ! function_exists('upload_img_file'))
{
    function upload_img_file($file_id, $save_dir)
    {
        $CI =& get_instance();

        $tmp_folder_name = 'data_tmp';

        $error = array(
            'status' => 1,
        );
        
        $upload_path = $tmp_folder_name."/".$save_dir."/".date("Y/m/d/");

        $upload_conf = $CI->upload_conf->upload_img_file($upload_path);
        $CI->upload->initialize($upload_conf);

        if (!$CI->upload->do_upload($file_id)) {
            $errors = $CI->upload->display_errors('','');

            $error['status'] = -1;
            $error['data'] = $errors;

            return $error;
        }

        // 成功
        $upload_data = $CI->upload->data();

        $file_path = "";
        foreach (array_slice(explode("/", $upload_data['file_path']), -4, 3) as $value) {
            $file_path .= $value."/";
        }
        $upload_data['http_file'] = site_url($tmp_folder_name.'/'.$save_dir.'/'.$file_path.$upload_data['file_name'].'');
        $upload_data['path_file'] = FCPATH.$tmp_folder_name.'/'.$save_dir.'/'.$file_path.$upload_data['file_name'].'';

        $error['data'] = $upload_data;

        return $error;
    }
}