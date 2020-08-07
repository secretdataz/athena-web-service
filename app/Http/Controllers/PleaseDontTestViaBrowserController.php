<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PleaseDontTestViaBrowserController extends Controller
{
    public function please()
    {
        return response()->json([
            'message' => 'Yes, it\'s working, just not via GET method.',
            'support_discord' => 'https://discord.gg/u5N69Dy',
        ], 200, [],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
