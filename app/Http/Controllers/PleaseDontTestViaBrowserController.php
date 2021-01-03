<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PleaseDontTestViaBrowserController extends Controller
{
    public function please()
    {
        return response()->json([
            'message' => 'It\'s working. If you have any question please use the Discord server below. You\'re also not supposed to be accessing this service via your browser.',
            'support_discord' => 'https://discord.gg/u5N69Dy',
        ], 200, [],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
