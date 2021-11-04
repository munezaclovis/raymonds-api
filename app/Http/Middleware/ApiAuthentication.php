<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Token;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $secret = DB::table('oauth_clients')
            ->where('id', 2)
            ->pluck('secret')
            ->first();

        $request->merge([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => $secret,
        ]);

        $response = $next($request);
        $data = json_decode($response->getContent(), true);

        if(!array_key_exists('error', $data)){
            $user = (new \App\Models\User)->findForPassport($request->input('username'));
            $data = [
                'data' => array_merge(
                    [
                        'token' => $data
                    ],
                    [
                        'user' => new UserResource($user)
                    ]
                )
            ];
        }

        $response->setContent($data);
        return $response;
    }
}
