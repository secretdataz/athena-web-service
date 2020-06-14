<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmblemController extends Controller
{
    const TABLE = 'guild_emblems';
    const STORAGE_DIRECTORY = 'emblems';

    public function upload(Request $request)
    {
        if ($request->guild_id === 0 || !$request->has('ImgType') || !$request->hasFile('Img') || ($request->input('ImgType') !== 'BMP' && $request->input('ImgType') !== 'GIF')) {
            return config('athena.error_response');
        }

        $file = $request->file('Img');
        if (!$file->isValid() || $file->getSize() > 50*1024) {
            return config('athena.error_response');
        }

        $old_data = DB::table(self::TABLE)->where('guild_id', $request->guild_id)->where('world_name', $request->world_name)->first();
        $file_name = $file->store(self::STORAGE_DIRECTORY);
        $version = 0;
        if ($old_data) {
            Storage::delete($old_data->file_name);
            $version = $old_data->version + 1;
            DB::table(self::TABLE)->where('guild_id', $request->guild_id)->where('world_name', $request->world_name)
                ->update([
                    'file_name' => $file_name,
                    'version' => $version,
            ]);
        } else {
            DB::table(self::TABLE)->insert([
                'guild_id' => $request->guild_id,
                'world_name' => $request->world_name,
                'file_name' => $file_name,
                'version' => 0,
            ]);
        }

        return [
            'Type' => 1,
            'version' => $version,
        ];
    }

    public function download(Request $request)
    {
        $version = $request->input('Version') ?? 0;
        $emblem = DB::table(self::TABLE)->where('guild_id', $request->guild_id)->where('world_name', $request->world_name)->first();
        if ($emblem) {
            if (true || $emblem->version > $version)// TODO: Support versioning
                return Storage::download($emblem->file_name);
        } else {
            return response('{"Type": 4}', 404);
        }
    }
}
