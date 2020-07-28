<?php
namespace App\Auth;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class AuthTokenVerifier
{
    static function verify(int $accountId, string $authToken, int $guildId = 0): bool
    {
        return DB::table('login')->where('login.account_id', $accountId)->where('login.web_auth_token', $authToken)
                ->when($guildId !== 0, function (Builder $q) use ($guildId) {
                    return $q->join('char', 'login.account_id', '=', 'char.account_id')
                        ->join('guild', 'guild.char_id', '=', 'char.char_id')
                        ->where('guild.guild_id', $guildId)
                        ->where('online', true);
                })->count() > 0;
    }
}
