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
        $data = DB::table(Utils::tb(self::TABLE))
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
        $inputData = json_decode($request->input('data'), true);
        $oldData = DB::table(Utils::tb(self::TABLE))->where('account_id', $aid)->where('world_name', $world)->first();

        $newData = [
            'data' => [
                'EmotionHotkey' => null,
                'UserHotkey_V2' => [
                    'EmotionTab' => null,
                    'InterfaceTab' => null,
                    'SkillBar_1Tab' => null,
                    'SkillBar_2Tab' => null,
                ],
                'UserHotkey' => null,
            ]
        ];

        if ($oldData) {
            $oldJson = json_decode($oldData->data, true);

            if (isset($oldJson['data']['EmotionHotkey']) && $oldJson['data']['EmotionHotkey'] != null) {
                $newData['data']['EmotionHotkey'] = $oldJson['data']['EmotionHotkey'];
            }
            if (isset($oldJson['data']['UserHotkey']) && $oldJson['data']['UserHotkey'] != null) {
                $newData['data']['UserHotkey'] = $oldJson['data']['UserHotkey'];
            }
            if (isset($oldJson['data']['UserHotkey_V2']['EmotionTab']) && $oldJson['data']['UserHotkey_V2']['EmotionTab'] != null) {
                $newData['data']['UserHotkey_V2']['EmotionTab'] = $oldJson['data']['UserHotkey_V2']['EmotionTab'];
            }
            if (isset($oldJson['data']['UserHotkey_V2']['InterfaceTab']) && $oldJson['data']['UserHotkey_V2']['InterfaceTab'] != null) {
                $newData['data']['UserHotkey_V2']['InterfaceTab'] = $oldJson['data']['UserHotkey_V2']['InterfaceTab'];
            }
            if (isset($oldJson['data']['UserHotkey_V2']['SkillBar_1Tab']) && $oldJson['data']['UserHotkey_V2']['SkillBar_1Tab'] != null) {
                $newData['data']['UserHotkey_V2']['SkillBar_1Tab'] = $oldJson['data']['UserHotkey_V2']['SkillBar_1Tab'];
            }
            if (isset($oldJson['data']['UserHotkey_V2']['SkillBar_2Tab']) && $oldJson['data']['UserHotkey_V2']['SkillBar_2Tab'] != null) {
                $newData['data']['UserHotkey_V2']['SkillBar_2Tab'] = $oldJson['data']['UserHotkey_V2']['SkillBar_2Tab'];
            }
        }

        if (isset($inputData['data']['EmotionHotkey']) && $inputData['data']['EmotionHotkey'] != null) {
            $newData['data']['EmotionHotkey'] = $inputData['data']['EmotionHotkey'];
        }
        if (isset($inputData['data']['UserHotkey']) && $inputData['data']['UserHotkey'] != null) {
            $newData['data']['UserHotkey'] = $inputData['data']['UserHotkey'];
        }
        if (isset($inputData['data']['UserHotkey_V2']['EmotionTab']) && $inputData['data']['UserHotkey_V2']['EmotionTab'] != null) {
            $newData['data']['UserHotkey_V2']['EmotionTab'] = $inputData['data']['UserHotkey_V2']['EmotionTab'];
        }
        if (isset($inputData['data']['UserHotkey_V2']['InterfaceTab']) && $inputData['data']['UserHotkey_V2']['InterfaceTab'] != null) {
            $newData['data']['UserHotkey_V2']['InterfaceTab'] = $inputData['data']['UserHotkey_V2']['InterfaceTab'];
        }
        if (isset($inputData['data']['UserHotkey_V2']['SkillBar_1Tab']) && $inputData['data']['UserHotkey_V2']['SkillBar_1Tab'] != null) {
            $newData['data']['UserHotkey_V2']['SkillBar_1Tab'] = $inputData['data']['UserHotkey_V2']['SkillBar_1Tab'];
        }
        if (isset($inputData['data']['UserHotkey_V2']['SkillBar_2Tab']) && $inputData['data']['UserHotkey_V2']['SkillBar_2Tab'] != null) {
            $newData['data']['UserHotkey_V2']['SkillBar_2Tab'] = $inputData['data']['UserHotkey_V2']['SkillBar_2Tab'];
        }
        $newData = json_encode($newData);

        try {
            if ($oldData) {
                DB::table(Utils::tb(self::TABLE))->where('account_id', $aid)->where('world_name', $world)
                    ->update([
                        'data' => $newData,
                    ]);
            } else {
                DB::table(Utils::tb(self::TABLE))->insert([
                    'account_id' => $aid,
                    'world_name' => $world,
                    'data' => $newData,
                ]);
            }

            return '{"Type": 1}';
        } catch(\Exception $e) {
            return response()->json(Utils::ErrorResponse($e), 404);
        }
    }
}
