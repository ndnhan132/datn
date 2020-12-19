<?php


if(!function_exists('asset_public_env')) {
    function asset_public_env($path)
    {
        if(strpos($path,'public/') !== false){
            $path = str_replace('public/', '/', $path);
        }

        if (app()->environment('production')) {
            $str = '/public/' . $path;
            $str = preg_replace('#/+#','/',$str);
            return asset($str);
        }
        elseif (app()->environment('local')) {
            return asset($path);
        }
        else{
            return asset($path);
        }
    }
}
