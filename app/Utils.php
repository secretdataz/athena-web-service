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

    static function ErrorResponse($msg): array
    {
        $error = config('athena.error_response');
        $error['Error'] = $msg;
        return $error;
    }

    static function tb(string $tableName): string
    {
        return config('athena.table_prefix') . $tableName;
    }
}
