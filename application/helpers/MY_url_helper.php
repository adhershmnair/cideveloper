<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('is_url_exist')){
    function is_url_exist($url = NULL){
        if ( ! empty($url) && filter_var($url, FILTER_VALIDATE_URL)){
            if (function_exists('curl_version')){
                $ch = curl_init($url);    

                curl_setopt($ch, CURLOPT_NOBODY, TRUE);
                curl_exec($ch);

                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($code == 200){
                    $status = TRUE;
                }else{
                    $status = FALSE;
                }

                curl_close($ch);

                return $status;
            }else{
                $headers = @get_headers($url);

                return stripos($headers[0], '200 OK') ? TRUE : FALSE;
            }
        }else{
            return FALSE;
        }
    }
}


if ( ! function_exists('slug')){
    function slug($name,$table='posts',$field='slug'){
        $i = 1;
        $max = 20; 
        $slug = url_title($name, '-', TRUE);
        while($i <= $max && ($exist = get_instance()->db->where($field, $slug)->count_all_results($table)) != 0) {
            $slug= increment_string($slug, '-');
            $i++;
        }
        //max was reached and the last slug is not unique
        if($i >= $max && $exist > 0) return FALSE;
        return $slug;
    }
}
