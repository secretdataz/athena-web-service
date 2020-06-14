<?php

namespace App\Http\Middleware;

use App\Auth\AuthTokenVerifier;
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validator = Validator::make($request->only(['AID', 'GDID', 'AuthToken', 'WorldName']), [
            'AID' => 'required',
            'GDID' => 'sometimes|required',
            'WorldName' => 'sometimes|required',
            'AuthToken' => 'sometimes|nullable|string'
        ]);
        if ($validator->fails()) {
			Log::info('Failed login (invalid payload) ' . json_encode($request->all()));
            return response(config('athena.error_response'), 401);
//            return response($validator->errors()->toJson(), 422);
        }
        $data = $validator->validated();

        $aid = (int) $data['AID'];
        $gid = $data['GDID'] ?? 0;
        $token = $data['AuthToken'] ?? '';
        $world = $data['WorldName'] ?? '';
        if (Arr::first(config('athena.allowed_worlds'), function ($v) use ($world) { return $v == $world; }, '') === '') {
			Log::info('Failed login (World not whitelisted) ' . json_encode($request->all()));
            return response(config('athena.error_response'), 401);
        }

        if (!AuthTokenVerifier::verify($aid, $token, $gid)) {
			Log::info('Failed login on route ' . $request->route() . ' ' . $request->getPathInfo() . ' (Auth token verification failed) ' . json_encode($request->all()));
            return response(config('athena.error_response'), 401);
        } else {
            $request->account_id = $aid;
            $request->guild_id = $gid;
            $request->auth_token = $token;
            $request->world_name = $world;
            return $next($request);
        }
    }
}
