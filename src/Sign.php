<?php

namespace ColdBlader\MeiTuan;

class Sign
{
    public static function makeContent(array $params): string
    {
        if (empty($params)) {
            return null;
        }
        ksort($params);
        $result_str = "";
        foreach ($params as $key => $val) {
            if ($key != "sign" && $val != null && $val != "") {
                $result_str = $result_str . $key . $val;
            }
        }
        return $result_str;
    
    }

    public static function makeSign(string $signKey, string $content): string
    {
        $result_str = $signKey . $content;

        $ret = bin2hex(sha1($result_str, true));

        return $ret;
    }
}