<?php 

/**
 * 
 * 按照比例计算图片大小
 */

if ( ! function_exists('chang_image_size'))
{
    function chang_image_size($img_w, $img_h, $max_w, $max_h)
    {
        $CI =& get_instance();
        
        if (!($img_w > 0 && $img_h > 0)) {
            return FALSE;
        }
        
        // 计算缩放比例
        $w_ratio = $max_w / $img_w;
        $h_ratio = $max_h / $img_h;
        
        // 决定处理后的图片宽和高
        if ( ($img_w <= $max_w) && ($img_h <= $max_h) )
        {
            $tn['w'] = $img_w;
            $tn['h'] = $img_h;
        }
        elseif (($w_ratio * $img_h) < $max_h)
        {
            $tn['w'] = $max_w;
            $tn['h'] = ceil($w_ratio * $img_h);
        }
        else 
		{
            $tn['w'] = ceil($h_ratio * $img_w);
            $tn['h'] = $max_h;
        }
        
        $tn['rc_w'] = $img_w;
        $tn['rc_h'] = $img_h;
        
        return $tn ;
    }
}