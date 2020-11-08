<?php

namespace App\Http\Controllers;

use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserConfigController extends Controller
{
    const TABLE = 'user_configs';

    public function load(Request $request)
    {
        $data = DB::table(self::TABLE)
            ->where('account_id', $request->account_id)
            ->where('world_name', $request->world_name)
            ->first();

        if (!$data) {
//            return response()->json(Utils::ErrorResponse('User config not found'), 404);
            return '{"Type": 1}';
        }

        $data = json_decode($data->data, true);
        $data['Type'] = 1;
        return $data;
    }

    public function save(Request $request)
    {
        $aid = $request->account_id;
        $world = $request->world_name;
        $data = Utils::AddType1($request->input('data'));
        try {
            $cnt = DB::table(self::TABLE)->where('account_id', $aid)->where('world_name', $world)->count();
            if ($cnt > 0) {
                DB::table(self::TABLE)->where('account_id', $aid)->where('world_name', $world)
                    ->update([
                        'data' => $data,
                    ]);
            } else {
                DB::table(self::TABLE)->insert([
                    'account_id' => $aid,
                    'world_name' => $world,
                    'data' => $data,
                ]);
            }

            return '{"Type": 1}';
        } catch(\Exception $e) {
            return response()->json(Utils::ErrorResponse($e), 404);
        }
    }
}
