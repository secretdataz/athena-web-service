<?php

namespace App\Http\Middleware;

use App\Auth\AuthTokenVerifier;
use App\Utils;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RagnarokAuthTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param bool $auth
     * @return mixed
     */
    public function handle($request, Closure $next, $auth = true)
    {
        $auth = filter_var($auth, FILTER_VALIDATE_BOOLEAN);
        $validator = Validator::make($request->only(['AID', 'GDID', 'AuthToken', 'WorldName']), [
            'AID' => 'required',
            'GDID' => 'sometimes|required',
            'WorldName' => 'sometimes|required',
            'AuthToken' => 'sometimes|nullable|string'
        ]);
        if ($validator->fails()) {
            return response(Utils::ErrorResponse($validator->errors()->toJson()), 401);
        }
        $data = $validator->validated();

        $aid = (int) $data['AID'];
        $gid = $data['GDID'] ?? 0;
        $token = $data['AuthToken'] ?? '';
        $world = $data['WorldName'] ?? '';
        if (Arr::first(config('athena.allowed_worlds'), function ($v) use ($world) { return $v == $world; }, '') === '') {
            return response(Utils::ErrorResponse('World ' . $world . ' is not allowed'), 401);
        }

        if ($auth && !AuthTokenVerifier::verify($aid, $token, $gid)) {
            return response(Utils::ErrorResponse('Authentication failed'), 401);
        } else {
            $request->account_id = $aid;
            $request->guild_id = $gid;
            $request->auth_token = $token;
            $request->world_name = $world;
            return $next($request);
        }
    }
}
