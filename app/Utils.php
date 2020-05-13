<?php
namespace App;

class Utils
{
    static function AddType1(string $json): string
    {
        $obj = json_decode($json, true);
        $obj['Type'] = 1;
        return json_encode($obj);
    }
}
