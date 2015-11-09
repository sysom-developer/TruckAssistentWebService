<?php

/**
 * 
 * 根据数组某一项进行排序
 */
if ( ! function_exists('multi_array_sort'))
{
    function multi_array_sort($multi_array, $sort_key, $sort_order=SORT_ASC, $sort_type=SORT_NUMERIC ) {
        if (is_array($multi_array)) {
            foreach ($multi_array as $row_array) {
                if (is_array($row_array)) {
                    $key_array[] = $row_array[$sort_key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        array_multisort($key_array, $sort_order, $sort_type, $multi_array);
        return $multi_array;
    }
}

?>