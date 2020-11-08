<?php

namespace App\Http\Middleware;

use App\Auth\AuthTokenVerifier;
use App\Utils;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Output\ConsoleOutput;

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
        $output = new ConsoleOutput();
        if (config('athena.dump_requests')) {
            // Dump the request into console when running via php artisan serve
            $output->writeln(json_encode(request()->all(), JSON_PRETTY_PRINT) . PHP_EOL);
        }

        $auth = filter_var($auth, FILTER_VALIDATE_BOOLEAN);
        $validator = Validator::make($request->only(['AID', 'GDID', 'AuthToken', 'WorldName']), [
            'AID' => 'required',
            'GDID' => 'sometimes|required',
            'WorldName' => 'sometimes|required',
            'AuthToken' => 'sometimes|nullable|string'
        ]);
        if ($validator->fails()) {
            if (config('athena.log_failed_auth')) {
                $output->writeln('Input validation failed' . PHP_EOL);
            }
            return response(Utils::ErrorResponse($validator->errors()->toJson()), 401);
        }
        $data = $validator->validated();

        $aid = (int) $data['AID'];
        $gid = $data['GDID'] ?? 0;
        $token = $data['AuthToken'] ?? '';
        $world = $data['WorldName'] ?? '';
        if (Arr::first(config('athena.allowed_worlds'), function ($v) use ($world) { return $v == $world; }, '') === '') {
            if (config('athena.log_failed_auth')) {
                $output->writeln('World ' . $world . 'not allowed' . PHP_EOL);
            }
            return response(Utils::ErrorResponse('World ' . $world . ' is not allowed'), 401);
        }

        if ($auth && !AuthTokenVerifier::verify($aid, $token, $gid)) {
            if (config('athena.log_failed_auth')) {
                $output->writeln('Token validation failed' . PHP_EOL);
            }
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
