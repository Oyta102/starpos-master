<?php
/**
 * @Copyright Oyta
 * @Author Oyta
 * @Email oyta@daucn.com
 * @Version 1.0
 */

namespace Oyta\Starpos\Http;

class Sign
{
    public static function set($data,$key)
    {
        //ksort($data);
        $str =  implode("",$data);
        return md5($str.$key);
    }
}
